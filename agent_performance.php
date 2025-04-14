<?php
require_once('config.php');
require_once('includes/functions.php');

// Ensure user is logged in
requireLogin();

// Get date range parameters
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-d');
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-d');

// Get agent statistics
$stats = getCallStats('realtime'); // We'll use realtime stats for now
$agent_stats = $stats['agent_stats'];

require_once('includes/header.php');
?>

<div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Page Header -->
    <div class="pb-5 border-b border-gray-200 sm:flex sm:items-center sm:justify-between">
        <h3 class="text-2xl leading-6 font-medium text-gray-900">
            Agent Performance
        </h3>
        <div class="mt-3 sm:mt-0 sm:ml-4">
            <form class="flex items-center space-x-4">
                <div class="flex items-center space-x-2">
                    <label class="text-sm text-gray-700">From:</label>
                    <input type="date" 
                           name="start_date" 
                           value="<?php echo htmlspecialchars($start_date); ?>"
                           class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>
                <div class="flex items-center space-x-2">
                    <label class="text-sm text-gray-700">To:</label>
                    <input type="date" 
                           name="end_date" 
                           value="<?php echo htmlspecialchars($end_date); ?>"
                           class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                    Apply
                </button>
            </form>
        </div>
    </div>

    <!-- Performance Overview Cards -->
    <div class="mt-8 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
        <?php foreach ($agent_stats as $agent): ?>
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                        <i class="fas fa-user text-white text-xl"></i>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">
                                <?php echo htmlspecialchars($agent['agent']); ?>
                            </dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-gray-900">
                                    <?php echo $agent['status']; ?>
                                </div>
                            </dd>
                        </dl>
                    </div>
                </div>
                <div class="mt-5">
                    <dl class="grid grid-cols-2 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Total Calls</dt>
                            <dd class="mt-1 text-lg font-semibold text-gray-900"><?php echo number_format($agent['total_calls']); ?></dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Avg Talk Time</dt>
                            <dd class="mt-1 text-lg font-semibold text-gray-900"><?php echo formatDuration($agent['avg_talk_time']); ?></dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Calls/Hour</dt>
                            <dd class="mt-1 text-lg font-semibold text-gray-900"><?php echo number_format($agent['calls_per_hour'], 1); ?></dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Login Time</dt>
                            <dd class="mt-1 text-lg font-semibold text-gray-900"><?php echo formatDuration($agent['total_login_time']); ?></dd>
                        </div>
                    </dl>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-4 sm:px-6">
                <!-- Time Distribution Chart -->
                <canvas id="timeChart_<?php echo str_replace(' ', '_', $agent['agent']); ?>" class="w-full h-32"></canvas>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Detailed Performance Table -->
    <div class="mt-8 flex flex-col">
        <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900">Agent</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Status</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Total Calls</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Avg Talk Time</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Available Time</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Break Time</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Calls/Hour</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            <?php foreach ($agent_stats as $agent): ?>
                            <tr>
                                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900">
                                    <?php echo htmlspecialchars($agent['agent']); ?>
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm">
                                    <span class="inline-flex rounded-full px-2 text-xs font-semibold leading-5 
                                        <?php echo $agent['status'] === 'Available' ? 'bg-green-100 text-green-800' : 
                                            ($agent['status'] === 'On Call' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800'); ?>">
                                        <?php echo $agent['status']; ?>
                                    </span>
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                    <?php echo number_format($agent['total_calls']); ?>
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                    <?php echo formatDuration($agent['avg_talk_time']); ?>
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                    <?php echo formatDuration($agent['available_time']); ?>
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                    <?php echo formatDuration($agent['break_time']); ?>
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                    <?php echo number_format($agent['calls_per_hour'], 1); ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    <?php foreach ($agent_stats as $agent): ?>
    new Chart(document.getElementById('timeChart_<?php echo str_replace(' ', '_', $agent['agent']); ?>').getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: ['Available', 'On Call', 'Break'],
            datasets: [{
                data: [
                    <?php echo $agent['available_time']; ?>,
                    <?php echo $agent['total_login_time'] - $agent['available_time'] - $agent['break_time']; ?>,
                    <?php echo $agent['break_time']; ?>
                ],
                backgroundColor: [
                    'rgb(34, 197, 94)',
                    'rgb(59, 130, 246)',
                    'rgb(239, 68, 68)'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        boxWidth: 12
                    }
                }
            }
        }
    });
    <?php endforeach; ?>
});
</script>

<?php require_once('includes/footer.php'); ?>

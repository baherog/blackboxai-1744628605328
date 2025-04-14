<?php
require_once('config.php');
require_once('includes/functions.php');

// Ensure user is logged in
requireLogin();

// Get date range parameters
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-d', strtotime('-30 days'));
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-d');

// Get daily statistics for the date range
$stats = getCallStats('daily', $start_date, $end_date);

require_once('includes/header.php');
?>

<div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Page Header -->
    <div class="pb-5 border-b border-gray-200 sm:flex sm:items-center sm:justify-between">
        <h3 class="text-2xl leading-6 font-medium text-gray-900">
            Abandoned Calls Analysis
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

    <!-- Summary Cards -->
    <div class="mt-8 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
        <!-- Total Abandoned -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <dt class="text-sm font-medium text-gray-500 truncate">Total Abandoned Calls</dt>
                <dd class="mt-1 text-3xl font-semibold text-gray-900">
                    <?php 
                    $total_abandoned = array_sum(array_column($stats, 'abandoned_calls'));
                    echo number_format($total_abandoned);
                    ?>
                </dd>
            </div>
        </div>

        <!-- Abandonment Rate -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <dt class="text-sm font-medium text-gray-500 truncate">Average Abandonment Rate</dt>
                <dd class="mt-1 text-3xl font-semibold text-gray-900">
                    <?php 
                    $total_calls = array_sum(array_column($stats, 'total_calls'));
                    $abandonment_rate = ($total_calls > 0) ? ($total_abandoned / $total_calls * 100) : 0;
                    echo number_format($abandonment_rate, 1) . '%';
                    ?>
                </dd>
            </div>
        </div>

        <!-- Average Wait Time -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <dt class="text-sm font-medium text-gray-500 truncate">Average Wait Time</dt>
                <dd class="mt-1 text-3xl font-semibold text-gray-900">
                    <?php 
                    $avg_duration = array_sum(array_column($stats, 'avg_duration')) / count($stats);
                    echo formatDuration($avg_duration);
                    ?>
                </dd>
            </div>
        </div>

        <!-- Peak Abandonment Day -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <dt class="text-sm font-medium text-gray-500 truncate">Peak Abandonment Day</dt>
                <dd class="mt-1 text-3xl font-semibold text-gray-900">
                    <?php 
                    $peak_day = array_reduce($stats, function($carry, $item) {
                        if (!$carry || $item['abandoned_calls'] > $carry['abandoned_calls']) {
                            return $item;
                        }
                        return $carry;
                    });
                    echo date('M j', strtotime($peak_day['date']));
                    ?>
                </dd>
            </div>
        </div>
    </div>

    <!-- Stats Table -->
    <div class="mt-8 flex flex-col">
        <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900">Date</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Total Calls</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Abandoned Calls</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Abandonment Rate</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Avg Wait Time</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Active Agents</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            <?php foreach ($stats as $daily_stat): ?>
                            <tr>
                                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900">
                                    <?php echo date('M j, Y', strtotime($daily_stat['date'])); ?>
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                    <?php echo number_format($daily_stat['total_calls']); ?>
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                    <?php echo number_format($daily_stat['abandoned_calls']); ?>
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                    <?php 
                                    $daily_rate = ($daily_stat['total_calls'] > 0) 
                                        ? ($daily_stat['abandoned_calls'] / $daily_stat['total_calls'] * 100) 
                                        : 0;
                                    echo number_format($daily_rate, 1) . '%';
                                    ?>
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                    <?php echo formatDuration($daily_stat['avg_duration']); ?>
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                    <?php echo number_format($daily_stat['total_agents']); ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Section -->
    <div class="mt-8">
        <canvas id="abandonedChart" class="w-full h-64"></canvas>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('abandonedChart').getContext('2d');
    const stats = <?php echo json_encode($stats); ?>;
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: stats.map(stat => new Date(stat.date).toLocaleDateString()),
            datasets: [{
                label: 'Abandoned Calls',
                data: stats.map(stat => stat.abandoned_calls),
                borderColor: 'rgb(239, 68, 68)',
                backgroundColor: 'rgba(239, 68, 68, 0.1)',
                fill: true,
                tension: 0.1
            }, {
                label: 'Total Calls',
                data: stats.map(stat => stat.total_calls),
                borderColor: 'rgb(59, 130, 246)',
                backgroundColor: 'transparent',
                borderDash: [5, 5],
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
});
</script>

<?php require_once('includes/footer.php'); ?>

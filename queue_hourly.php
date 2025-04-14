<?php
require_once('config.php');
require_once('includes/functions.php');

// Ensure user is logged in
requireLogin();

// Get the date parameter, default to today
$date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');

// Get hourly statistics
$stats = getCallStats('hourly', $date);

require_once('includes/header.php');
?>

<div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Page Header -->
    <div class="pb-5 border-b border-gray-200 sm:flex sm:items-center sm:justify-between">
        <h3 class="text-2xl leading-6 font-medium text-gray-900">
            Hourly Queue Statistics
        </h3>
        <div class="mt-3 sm:mt-0 sm:ml-4">
            <form class="flex items-center space-x-4">
                <input type="date" 
                       name="date" 
                       value="<?php echo htmlspecialchars($date); ?>"
                       class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                       onchange="this.form.submit()">
            </form>
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
                                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900">Hour</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Total Calls</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Answered</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Abandoned</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Avg Duration</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Avg Talk Time</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            <?php foreach ($stats as $hour_stat): ?>
                            <tr>
                                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900">
                                    <?php echo sprintf('%02d:00', $hour_stat['hour']); ?>
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                    <?php echo number_format($hour_stat['total_calls']); ?>
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                    <?php echo number_format($hour_stat['answered_calls']); ?>
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                    <?php echo number_format($hour_stat['abandoned_calls']); ?>
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                    <?php echo formatDuration($hour_stat['avg_duration']); ?>
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                    <?php echo formatDuration($hour_stat['avg_talk_time']); ?>
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
        <canvas id="hourlyChart" class="w-full h-64"></canvas>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('hourlyChart').getContext('2d');
    const stats = <?php echo json_encode($stats); ?>;
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: stats.map(stat => `${stat.hour}:00`),
            datasets: [{
                label: 'Total Calls',
                data: stats.map(stat => stat.total_calls),
                borderColor: 'rgb(59, 130, 246)',
                tension: 0.1
            }, {
                label: 'Answered Calls',
                data: stats.map(stat => stat.answered_calls),
                borderColor: 'rgb(34, 197, 94)',
                tension: 0.1
            }, {
                label: 'Abandoned Calls',
                data: stats.map(stat => stat.abandoned_calls),
                borderColor: 'rgb(239, 68, 68)',
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

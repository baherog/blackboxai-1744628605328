<?php
require_once('config.php');
require_once('includes/functions.php');

// Ensure user is logged in
requireLogin();

// Get date range parameters
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-d', strtotime('-30 days'));
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-d');
$report_type = isset($_GET['type']) ? $_GET['type'] : 'daily';

// Get statistics based on report type
$stats = getCallStats($report_type, $start_date, $end_date);

require_once('includes/header.php');
?>

<div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Page Header -->
    <div class="pb-5 border-b border-gray-200 sm:flex sm:items-center sm:justify-between">
        <h3 class="text-2xl leading-6 font-medium text-gray-900">
            Custom Report
        </h3>
        <div class="mt-3 sm:mt-0 sm:ml-4">
            <form class="flex items-center space-x-4">
                <div class="flex items-center space-x-2">
                    <label class="text-sm text-gray-700">Type:</label>
                    <select name="type" 
                            class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            onchange="this.form.submit()">
                        <option value="hourly" <?php echo $report_type === 'hourly' ? 'selected' : ''; ?>>Hourly</option>
                        <option value="daily" <?php echo $report_type === 'daily' ? 'selected' : ''; ?>>Daily</option>
                        <option value="monthly" <?php echo $report_type === 'monthly' ? 'selected' : ''; ?>>Monthly</option>
                        <option value="yearly" <?php echo $report_type === 'yearly' ? 'selected' : ''; ?>>Yearly</option>
                    </select>
                </div>
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
                    Generate Report
                </button>
            </form>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="mt-8 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
        <!-- Total Calls -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <dt class="text-sm font-medium text-gray-500 truncate">Total Calls</dt>
                <dd class="mt-1 text-3xl font-semibold text-gray-900">
                    <?php 
                    $total_calls = array_sum(array_column($stats, 'total_calls'));
                    echo number_format($total_calls);
                    ?>
                </dd>
            </div>
        </div>

        <!-- Average Duration -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <dt class="text-sm font-medium text-gray-500 truncate">Average Duration</dt>
                <dd class="mt-1 text-3xl font-semibold text-gray-900">
                    <?php 
                    $avg_duration = array_sum(array_column($stats, 'avg_duration')) / count($stats);
                    echo formatDuration($avg_duration);
                    ?>
                </dd>
            </div>
        </div>

        <!-- Total Agents -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <dt class="text-sm font-medium text-gray-500 truncate">Total Agents</dt>
                <dd class="mt-1 text-3xl font-semibold text-gray-900">
                    <?php 
                    $max_agents = max(array_column($stats, 'total_agents'));
                    echo number_format($max_agents);
                    ?>
                </dd>
            </div>
        </div>

        <!-- Average Talk Time -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <dt class="text-sm font-medium text-gray-500 truncate">Average Talk Time</dt>
                <dd class="mt-1 text-3xl font-semibold text-gray-900">
                    <?php 
                    $avg_talk_time = array_sum(array_column($stats, 'avg_talk_time')) / count($stats);
                    echo formatDuration($avg_talk_time);
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
                                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900">Period</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Total Calls</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Answered</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Abandoned</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Avg Duration</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Active Agents</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Avg Talk Time</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            <?php foreach ($stats as $stat): ?>
                            <tr>
                                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900">
                                    <?php
                                    switch ($report_type) {
                                        case 'hourly':
                                            echo sprintf('%02d:00', $stat['hour']);
                                            break;
                                        case 'daily':
                                            echo date('M j, Y', strtotime($stat['date']));
                                            break;
                                        case 'monthly':
                                            echo date('M Y', strtotime($stat['month'] . '-01'));
                                            break;
                                        case 'yearly':
                                            echo $stat['year'];
                                            break;
                                    }
                                    ?>
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                    <?php echo number_format($stat['total_calls']); ?>
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                    <?php echo number_format($stat['answered_calls']); ?>
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                    <?php echo number_format($stat['abandoned_calls']); ?>
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                    <?php echo formatDuration($stat['avg_duration']); ?>
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                    <?php echo number_format($stat['total_agents']); ?>
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                    <?php echo formatDuration($stat['avg_talk_time']); ?>
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
        <canvas id="customChart" class="w-full h-64"></canvas>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('customChart').getContext('2d');
    const stats = <?php echo json_encode($stats); ?>;
    const reportType = '<?php echo $report_type; ?>';
    
    const labels = stats.map(stat => {
        switch (reportType) {
            case 'hourly':
                return `${stat.hour}:00`;
            case 'daily':
                return new Date(stat.date).toLocaleDateString();
            case 'monthly':
                return new Date(stat.month + '-01').toLocaleDateString('en-US', { month: 'short', year: 'numeric' });
            case 'yearly':
                return stat.year;
            default:
                return '';
        }
    });

    new Chart(ctx, {
        type: reportType === 'yearly' ? 'bar' : 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Total Calls',
                data: stats.map(stat => stat.total_calls),
                borderColor: 'rgb(59, 130, 246)',
                backgroundColor: 'rgba(59, 130, 246, 0.5)',
                tension: 0.1
            }, {
                label: 'Answered Calls',
                data: stats.map(stat => stat.answered_calls),
                borderColor: 'rgb(34, 197, 94)',
                backgroundColor: 'rgba(34, 197, 94, 0.5)',
                tension: 0.1
            }, {
                label: 'Abandoned Calls',
                data: stats.map(stat => stat.abandoned_calls),
                borderColor: 'rgb(239, 68, 68)',
                backgroundColor: 'rgba(239, 68, 68, 0.5)',
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

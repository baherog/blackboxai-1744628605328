<?php
require_once('config.php');
require_once('includes/functions.php');

// Ensure user is logged in
requireLogin();

// Get call statistics
$stats = getCallStats();

require_once('includes/header.php');
?>

<div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Page Header -->
    <div class="pb-5 border-b border-gray-200 sm:flex sm:items-center sm:justify-between">
        <h3 class="text-2xl leading-6 font-medium text-gray-900">
            Call Center Dashboard
        </h3>
        <div class="mt-3 sm:mt-0 sm:ml-4">
            <span class="text-sm font-medium text-gray-500">Last updated: <?php echo date('Y-m-d H:i:s'); ?></span>
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="mt-8 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
        <!-- Total Calls -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                        <i class="fas fa-phone text-white text-xl"></i>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">
                                Total Calls Today
                            </dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-gray-900">
                                    <?php echo number_format($stats['total_calls']); ?>
                                </div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Active Calls -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                        <i class="fas fa-headset text-white text-xl"></i>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">
                                Active Calls
                            </dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-gray-900">
                                    <?php echo number_format($stats['active_calls']); ?>
                                </div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <!-- Average Duration -->
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                        <i class="fas fa-clock text-white text-xl"></i>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">
                                Average Call Duration
                            </dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-gray-900">
                                    <?php echo formatDuration($stats['avg_duration']); ?>
                                </div>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Detailed Stats -->
    <div class="mt-8 grid grid-cols-1 gap-5 lg:grid-cols-2">
        <!-- Queue Statistics -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Queue Statistics
                </h3>
            </div>
            <div class="px-4 py-5 sm:p-6">
                <div class="flow-root">
                    <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                            <table class="min-w-full divide-y divide-gray-300">
                                <thead>
                                    <tr>
                                        <th class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900">Queue</th>
                                        <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Total Calls</th>
                                        <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Avg Wait Time</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    <?php foreach ($stats['queue_stats'] as $queue): ?>
                                    <tr>
                                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900">
                                            <?php echo htmlspecialchars($queue['queue_name']); ?>
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                            <?php echo number_format($queue['total_calls']); ?>
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                            <?php echo formatDuration($queue['avg_wait']); ?>
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

        <!-- Agent Statistics -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Agent Statistics
                </h3>
            </div>
            <div class="px-4 py-5 sm:p-6">
                <div class="flow-root">
                    <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                            <table class="min-w-full divide-y divide-gray-300">
                                <thead>
                                    <tr>
                                        <th class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900">Agent</th>
                                        <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Total Calls</th>
                                        <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Avg Talk Time</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    <?php foreach ($stats['agent_stats'] as $agent): ?>
                                    <tr>
                                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900">
                                            <?php echo htmlspecialchars($agent['agent']); ?>
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                            <?php echo number_format($agent['total_calls']); ?>
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                            <?php echo formatDuration($agent['avg_talk_time']); ?>
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
    </div>
</div>

<script>
// Auto-refresh the page every 30 seconds
setTimeout(function() {
    window.location.reload();
}, 30000);
</script>

<?php require_once('includes/footer.php'); ?>

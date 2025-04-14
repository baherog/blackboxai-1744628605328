<?php
require_once('config.php');
require_once('includes/functions.php');

// Ensure user is logged in
requireLogin();

// Get date range parameters
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-d');
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-d');

// Get agent statistics
$stats = getCallStats('realtime'); // Using realtime stats for demo
$agent_stats = $stats['agent_stats'];

require_once('includes/header.php');
?>

<div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Page Header -->
    <div class="pb-5 border-b border-gray-200 sm:flex sm:items-center sm:justify-between">
        <h3 class="text-2xl leading-6 font-medium text-gray-900">
            Agent Login Times
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

    <!-- Time Distribution Summary -->
    <div class="mt-8 grid grid-cols-1 gap-5 sm:grid-cols-3">
        <?php foreach ($agent_stats as $agent): ?>
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                        <i class="fas fa-user-clock text-white text-xl"></i>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">
                                <?php echo htmlspecialchars($agent['agent']); ?>
                            </dt>
                            <dd class="flex items-baseline">
                                <div class="text-2xl font-semibold text-gray-900">
                                    <?php echo formatDuration($agent['total_login_time']); ?>
                                </div>
                                <span class="ml-2 text-sm text-gray-500">total login time</span>
                            </dd>
                        </dl>
                    </div>
                </div>

                <!-- Time Distribution -->
                <div class="mt-6">
                    <div class="space-y-4">
                        <!-- Available Time -->
                        <div>
                            <div class="flex items-center justify-between">
                                <div class="text-sm font-medium text-gray-500">Available Time</div>
                                <div class="text-sm font-medium text-gray-900">
                                    <?php echo formatDuration($agent['available_time']); ?>
                                </div>
                            </div>
                            <div class="mt-1 relative">
                                <div class="overflow-hidden h-2 text-xs flex rounded bg-gray-200">
                                    <div style="width:<?php echo ($agent['available_time'] / $agent['total_login_time']) * 100; ?>%" 
                                         class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-green-500">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Break Time -->
                        <div>
                            <div class="flex items-center justify-between">
                                <div class="text-sm font-medium text-gray-500">Break Time</div>
                                <div class="text-sm font-medium text-gray-900">
                                    <?php echo formatDuration($agent['break_time']); ?>
                                </div>
                            </div>
                            <div class="mt-1 relative">
                                <div class="overflow-hidden h-2 text-xs flex rounded bg-gray-200">
                                    <div style="width:<?php echo ($agent['break_time'] / $agent['total_login_time']) * 100; ?>%" 
                                         class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-red-500">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Call Time -->
                        <?php $call_time = $agent['total_login_time'] - $agent['available_time'] - $agent['break_time']; ?>
                        <div>
                            <div class="flex items-center justify-between">
                                <div class="text-sm font-medium text-gray-500">Call Time</div>
                                <div class="text-sm font-medium text-gray-900">
                                    <?php echo formatDuration($call_time); ?>
                                </div>
                            </div>
                            <div class="mt-1 relative">
                                <div class="overflow-hidden h-2 text-xs flex rounded bg-gray-200">
                                    <div style="width:<?php echo ($call_time / $agent['total_login_time']) * 100; ?>%" 
                                         class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-blue-500">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Detailed Timeline -->
    <div class="mt-8">
        <h4 class="text-lg font-medium text-gray-900 mb-4">Detailed Timeline</h4>
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <div class="relative">
                    <?php foreach ($agent_stats as $agent): ?>
                    <div class="mb-8">
                        <h5 class="text-sm font-medium text-gray-900 mb-4"><?php echo htmlspecialchars($agent['agent']); ?></h5>
                        <div class="relative">
                            <!-- Timeline bar -->
                            <div class="h-4 bg-gray-200 rounded">
                                <?php
                                $total_width = 100;
                                $available_width = ($agent['available_time'] / $agent['total_login_time']) * $total_width;
                                $break_width = ($agent['break_time'] / $agent['total_login_time']) * $total_width;
                                $call_width = ($call_time / $agent['total_login_time']) * $total_width;
                                ?>
                                <div class="absolute h-4 bg-green-500 rounded-l" style="width: <?php echo $available_width; ?>%; left: 0;"></div>
                                <div class="absolute h-4 bg-red-500" style="width: <?php echo $break_width; ?>%; left: <?php echo $available_width; ?>%;"></div>
                                <div class="absolute h-4 bg-blue-500 rounded-r" style="width: <?php echo $call_width; ?>%; left: <?php echo $available_width + $break_width; ?>%;"></div>
                            </div>
                            <!-- Time markers -->
                            <div class="flex justify-between mt-1">
                                <span class="text-xs text-gray-500">00:00</span>
                                <span class="text-xs text-gray-500">06:00</span>
                                <span class="text-xs text-gray-500">12:00</span>
                                <span class="text-xs text-gray-500">18:00</span>
                                <span class="text-xs text-gray-500">24:00</span>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Legend -->
    <div class="mt-4 flex items-center justify-center space-x-8">
        <div class="flex items-center">
            <div class="w-4 h-4 bg-green-500 rounded mr-2"></div>
            <span class="text-sm text-gray-600">Available</span>
        </div>
        <div class="flex items-center">
            <div class="w-4 h-4 bg-red-500 rounded mr-2"></div>
            <span class="text-sm text-gray-600">Break</span>
        </div>
        <div class="flex items-center">
            <div class="w-4 h-4 bg-blue-500 rounded mr-2"></div>
            <span class="text-sm text-gray-600">On Call</span>
        </div>
    </div>
</div>

<?php require_once('includes/footer.php'); ?>

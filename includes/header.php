<?php require_once(__DIR__ . '/../config.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITE_TITLE; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body class="bg-gray-100">
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="flex-shrink-0 flex items-center">
                        <img class="h-8 w-auto" src="https://images.pexels.com/photos/1181671/pexels-photo-1181671.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" alt="Logo">
                        <span class="ml-2 text-xl font-bold text-gray-800"><?php echo SITE_TITLE; ?></span>
                    </div>
                </div>
                <?php if(isset($_SESSION['user'])): ?>
                <div class="flex items-center space-x-4">
                    <a href="dashboard.php" class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">Dashboard</a>
                    
                    <!-- Queue Reports Dropdown -->
                    <div class="relative group">
                        <button class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium flex items-center">
                            Queue Reports
                            <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div class="absolute left-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 hidden group-hover:block">
                            <div class="py-1">
                                <a href="queue_hourly.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Hourly Stats</a>
                                <a href="queue_daily.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Daily Stats</a>
                                <a href="queue_monthly.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Monthly Stats</a>
                                <a href="queue_yearly.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Yearly Stats</a>
                            </div>
                        </div>
                    </div>

                    <!-- Agent Reports Dropdown -->
                    <div class="relative group">
                        <button class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium flex items-center">
                            Agent Reports
                            <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div class="absolute left-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 hidden group-hover:block">
                            <div class="py-1">
                                <a href="agent_performance.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Performance</a>
                                <a href="agent_login_times.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Login Times</a>
                                <a href="agent_queue_matrix.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Queue Matrix</a>
                                <a href="agent_status.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Status Changes</a>
                                <a href="agent_calls.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Call Details</a>
                            </div>
                        </div>
                    </div>

                    <!-- Call Reports Dropdown -->
                    <div class="relative group">
                        <button class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium flex items-center">
                            Call Reports
                            <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div class="absolute left-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 hidden group-hover:block">
                            <div class="py-1">
                                <a href="call_distribution.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Distribution</a>
                                <a href="call_abandoned.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Abandoned Calls</a>
                                <a href="call_sla.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">SLA Reports</a>
                                <a href="call_wait_times.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Wait Times</a>
                            </div>
                        </div>
                    </div>

                    <!-- Custom Reports -->
                    <a href="custom_report.php" class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">Custom Report</a>
                    
                    <!-- Settings -->
                    <a href="settings.php" class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">Settings</a>
                    
                    <!-- Logout -->
                    <a href="logout.php" class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">Logout</a>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </nav>
    <main class="container mx-auto px-4 py-8">

<?php
/**
 * Generate demo realtime statistics
 */
function getDemoRealtimeStats() {
    return [
        'total_calls' => 156,
        'active_calls' => 12,
        'avg_duration' => 180,
        'completed_calls' => 142,
        'abandoned_calls' => 14,
        'avg_wait_time' => 45,
        'service_level' => 85,
        'queue_stats' => [
            [
                'queue_name' => 'Sales',
                'total_calls' => 85,
                'active_calls' => 7,
                'waiting_calls' => 3,
                'avg_wait' => 35,
                'sla_met' => 92,
                'abandoned' => 4,
                'completed' => 78
            ],
            [
                'queue_name' => 'Support',
                'total_calls' => 71,
                'active_calls' => 5,
                'waiting_calls' => 2,
                'avg_wait' => 55,
                'sla_met' => 88,
                'abandoned' => 6,
                'completed' => 63
            ]
        ],
        'agent_stats' => [
            [
                'agent' => 'Agent 1',
                'status' => 'On Call',
                'total_calls' => 45,
                'avg_talk_time' => 240,
                'total_login_time' => 28800,
                'available_time' => 25200,
                'break_time' => 3600,
                'calls_per_hour' => 5.6
            ],
            [
                'agent' => 'Agent 2',
                'status' => 'Available',
                'total_calls' => 52,
                'avg_talk_time' => 185,
                'total_login_time' => 28800,
                'available_time' => 26400,
                'break_time' => 2400,
                'calls_per_hour' => 6.5
            ],
            [
                'agent' => 'Agent 3',
                'status' => 'Break',
                'total_calls' => 59,
                'avg_talk_time' => 210,
                'total_login_time' => 28800,
                'available_time' => 24000,
                'break_time' => 4800,
                'calls_per_hour' => 7.4
            ]
        ]
    ];
}

/**
 * Generate demo hourly statistics
 */
function getDemoHourlyStats($date) {
    $stats = [];
    for ($hour = 0; $hour < 24; $hour++) {
        $total_calls = rand(15, 45);
        $answered = rand(12, $total_calls);
        $stats[] = [
            'hour' => $hour,
            'total_calls' => $total_calls,
            'avg_duration' => rand(120, 360),
            'answered_calls' => $answered,
            'abandoned_calls' => $total_calls - $answered,
            'avg_talk_time' => rand(180, 300)
        ];
    }
    return $stats;
}

/**
 * Generate demo daily statistics
 */
function getDemoDailyStats($start_date, $end_date) {
    $stats = [];
    $current = strtotime($start_date);
    $end = strtotime($end_date);
    
    while ($current <= $end) {
        $total_calls = rand(150, 450);
        $answered = rand(120, $total_calls);
        $stats[] = [
            'date' => date('Y-m-d', $current),
            'total_calls' => $total_calls,
            'avg_duration' => rand(120, 360),
            'answered_calls' => $answered,
            'abandoned_calls' => $total_calls - $answered,
            'total_agents' => rand(8, 15),
            'avg_talk_time' => rand(180, 300)
        ];
        $current = strtotime('+1 day', $current);
    }
    return $stats;
}

/**
 * Generate demo monthly statistics
 */
function getDemoMonthlyStats($start_date, $end_date) {
    $stats = [];
    $current = strtotime(date('Y-m-01', strtotime($start_date)));
    $end = strtotime(date('Y-m-t', strtotime($end_date)));
    
    while ($current <= $end) {
        $total_calls = rand(4500, 13500);
        $answered = rand(3600, $total_calls);
        $stats[] = [
            'month' => date('Y-m', $current),
            'total_calls' => $total_calls,
            'avg_duration' => rand(120, 360),
            'answered_calls' => $answered,
            'abandoned_calls' => $total_calls - $answered,
            'total_agents' => rand(8, 15),
            'avg_talk_time' => rand(180, 300)
        ];
        $current = strtotime('+1 month', $current);
    }
    return $stats;
}

/**
 * Generate demo yearly statistics
 */
function getDemoYearlyStats($start_date, $end_date) {
    $stats = [];
    $start_year = date('Y', strtotime($start_date));
    $end_year = date('Y', strtotime($end_date));
    
    for ($year = $start_year; $year <= $end_year; $year++) {
        $total_calls = rand(54000, 162000);
        $answered = rand(43200, $total_calls);
        $stats[] = [
            'year' => $year,
            'total_calls' => $total_calls,
            'avg_duration' => rand(120, 360),
            'answered_calls' => $answered,
            'abandoned_calls' => $total_calls - $answered,
            'total_agents' => rand(8, 15),
            'avg_talk_time' => rand(180, 300)
        ];
    }
    return $stats;
}
?>

<?php
function sb_cron() {
    sb_log_debug("sb_cron called");
    $data = sb_load();
    $sb_config = sb_config();
    $schedules = $data['schedules'];

    foreach ($schedules as $id => $schedule) {
        $next_run_time = Null;
        if (!isset($schedule['last_run_time']) || $schedule['last_run_time'] == Null) {
            $next_run_time = time();
        } else {
            $last_run_time = $schedule['last_run_time'];
            switch($schedule['frequency']) {
            case 'hourly':
                $next_run_time = getdate(strtotime("+1 hour", $last_run_time));
                $next_run_time['minutes'] = 0;
                $next_run_time['seconds'] = 0;
                $next_run_time = sb_remake_time($next_run_time);
                break;
            case 'daily':
                $next_run_time = getdate(strtotime("+1 day", $last_run_time));
                $next_run_time['hours'] = 0;
                $next_run_time['minutes'] = 0;
                $next_run_time['seconds'] = 0;
                $next_run_time = sb_remake_time($next_run_time);
                break;
            case 'weekly':
                $next_run_time = getdate(strtotime("+1 week", $last_run_time));
                $next_run_time['hours'] = 0;
                $next_run_time['minutes'] = 0;
                $next_run_time['seconds'] = 0;
                $next_run_time = sb_remake_time($next_run_time);
                break;
            case 'monthly':
                $next_run_time = getdate(strtotime("+1 month", $last_run_time));
                $next_run_time['mday'] = 0;
                $next_run_time['hours'] = 0;
                $next_run_time['minutes'] = 0;
                $next_run_time['seconds'] = 0;
                $next_run_time = sb_remake_time($next_run_time);
                break;
            default:
                sb_log_error("Unsupported frequency '%s' for schedule '%s'", array($schedule['frequency'], $schedule['name']));
                break;
            }
        }

        if ($next_run_time != Null && $next_run_time <= time()) {
            $result = sb_run_scheduled_backup($schedule);
            $schedule['last_run_time'] = time();
            $schedule['last_run_status'] = $result;

            sb_update_schedule($id, $schedule);
        }
    }
}

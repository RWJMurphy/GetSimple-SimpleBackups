<?php
function sb_log($level, $message, $args=Null) {
    $logs = sb_load_thing("logs");
    if (is_array($args)) {
        $message = vsprintf($message, $args);
    } elseif ($args != Null) {
        $message = sprintf($message, $args);
    }
    $log = array(
        "level" => $level,
        "timestamp" => time(),
        "message" => $message
    );
    $logs[] = $log;
    sb_save_thing("logs", $logs);
}

function sb_log_debug($message, $args=Null) {
    sb_log(SB_LOG_DEBUG, $message, $args);
}

function sb_log_info($message, $args=Null) {
    sb_log(SB_LOG_INFO, $message, $args);
}

function sb_log_warning($message, $args=Null) {
    sb_log(SB_LOG_WARNING, $message, $args);
}

function sb_log_error($message, $args=Null) {
    sb_log(SB_LOG_ERROR, $message, $args);
}

function sb_log_critical($message, $args=Null) {
    sb_log(SB_LOG_CRITICAL, $message, $args);
}

function sb_log_compare($a, $b) {
    $a = $a['timestamp'];
    $b = $b['timestamp'];
    return ($b - $a);
}

function sb_get_logs($filter=SB_LOG_DEBUG) {
    $logs = sb_load_thing("logs");
    $retlogs = array();
    foreach ($logs as $log) {
        if ($log['level'] >= $filter) {
            $retlogs[] = $log;
        }
    }
    usort($retlogs, "sb_log_compare");
    return $retlogs;
}

function sb_delete_log($id) {
    $logs = sb_load_thing("logs");
    unset($logs[$id]);
    $result = sb_save_thing("logs", $logs);
    if (!$result) {
        sb_set_error(i18n_r(SB_SHORTNAME.'/ERROR_DELETING_LOG'));
    }
    return $result;
}

function sb_delete_all_logs() {
    $result = sb_save_thing("logs", array());
    if (!$result) {
        sb_set_error(i18n_r(SB_SHORTNAME.'/ERROR_DELETING_LOGS'));
    }
    return $result;
}

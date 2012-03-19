<?php
function sb_add_schedule($postdata) {
    $schedule = array();
    $data = sb_load();
    $sb_config = sb_config();

    if (!$postdata['name']) {
        sb_set_error(i18n_r(SB_SHORTNAME.'/ERROR_VALID_NAME'));
    }
    if (!array_key_exists($postdata['frequency'], $sb_config['schedule_frequencies'])) {
        sb_set_error(i18n_r(SB_SHORTNAME.'/ERROR_VALID_FREQUENCY'));
    }
    if ($postdata['limit'] !== "" && intval($postdata['limit']) <= 0) {
        sb_set_error(i18n_r(SB_SHORTNAME.'/ERROR_VALID_LIMIT'));
    }
    if (!array_key_exists($postdata['source'], $data['sources'])) {
        sb_set_error(i18n_r(SB_SHORTNAME.'/ERROR_VALID_SOURCE'));
    }
    if (!array_key_exists($postdata['destination'], $data['destinations'])) {
        sb_set_error(i18n_r(SB_SHORTNAME.'/ERROR_VALID_DESTINATION'));
    }
    if (!in_array($postdata['archive_format'], $data['archive_formats'])) {
        sb_set_error(i18n_r(SB_SHORTNAME.'/ERROR_VALID_ARCHIVE_FORMAT'));
    }
    $schedule['name'] = $postdata['name'];
    $schedule['frequency'] = $postdata['frequency'];
    $schedule['limit'] = intval($postdata['limit']);
    $schedule['source'] = intval($postdata['source']);
    $schedule['destination'] = intval($postdata['destination']);
    $schedule['archive_format'] = $postdata['archive_format'];

    if (sb_has_error()) {
        return false;
    }

    $schedules = $data['schedules'];
    $schedules[] = $schedule;
    $result = sb_save_thing("schedules", $schedules);
    if (!$result) {
        sb_set_error(i18n_r(SB_SHORTNAME.'/ERROR_SAVING_SCHEDULE'));
    }
    return $result;
}

function sb_delete_schedule($id) {
    $schedules = sb_load_thing("schedules");
    unset($schedules[$id]);
    $result = sb_save_thing("schedules", $schedules);
    if (!$result) {
        sb_set_error(i18n_r(SB_SHORTNAME.'/ERROR_DELETING_SCHEDULE'));
    }
    return $result;
}

function sb_update_schedule($id, $schedule) {
    $schedules = sb_load_thing("schedules");
    $schedules[$id] = $schedule;
    $result = sb_save_thing("schedules", $schedules);
    if (!$result) {
        $error = i18n_r(SB_SHORTNAME.'/ERROR_UPDATING_SCHEDULE');
        sb_set_error($error, $schedule['name']);
        sb_log_error($error, $schedule['name']);
    }
    return $result;
}


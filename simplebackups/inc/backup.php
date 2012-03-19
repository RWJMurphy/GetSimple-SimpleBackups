<?php
require_once __DIR__.'/backup_archive_formats.php';

require_once __DIR__.'/backup_destination_local.php';
require_once __DIR__.'/backup_destination_ftp.php';
require_once __DIR__.'/backup_destination_s3.php';
require_once __DIR__.'/backup_destination_email.php';

function sb_run_backup($source, $destination, $format, $limit) {
    $result = False;

    $exclude = Null;
    if ($destination['type'] == "local") {
        $exclude = $destination['path'];
    }
    $archive = sb_create_backup($source, $format, $exclude);
    if ($archive !== False) {
        $upload_result = sb_upload_backup($archive, $destination);
        if ($upload_result === True) {
            $result = True;
        }
    }

    if ($limit) {
        $clean_result = sb_clean_backups($source, $destination, $format, $limit);
        $result &= $clean_result;
    }
    return $result;
}

function sb_create_backup($source, $format, $exclude=Null) {
    switch($format) {
    case ".tar.gz":
        $result = sb_create_targz($source, $exclude);
        break;
    default:
        sb_set_error(i18n_r(SB_SHORTNAME.'/UNSUPPORTED_ARCHIVE'), $format);
        $result = False;
        break;
    }
    return $result;
}

function sb_upload_backup($archive, $destination) {
    switch($destination['type']) {
    case "local":
        $result = sb_upload_local($archive, $destination);
        break;
    case "ftp":
        $result = sb_upload_ftp($archive, $destination);
        break;
    case "s3":
        $result = sb_upload_s3($archive, $destination);
        break;
    case "email":
        $result = sb_upload_email($archive, $destination);
        break;
    default:
        sb_set_error(i18n_r(SB_SHORTNAME.'/UNSUPPORTED_DESTINATION'), $destination['type']);
        $result = False;
        break;
    }
    if (!$result) {
        if (file_exists($archive)) {
            unlink($archive);
        }
    }
    return $result;
}

function sb_clean_backups($source, $destination, $format, $limit) {
    $match_pattern = sb_generate_pattern($source, $format);
    switch($destination['type']) {
    case "ftp":
        $result = sb_clean_ftp($destination, $match_pattern, $limit);
        break;
    case "s3":
        $result = sb_clean_s3($destination, $match_pattern, $limit);
        break;
    case "local":
        $result = sb_clean_local($destination, $match_pattern, $limit);
        break;
    case "email":
        $result = true;
        break;
    default:
        sb_set_error(i18n_r(SB_SHORTNAME.'/UNSUPPORTED_DESTINATION'), $destination['type']);
        $result = false;
        break;
    }
    return $result;
}

function sb_run_scheduled_backup($schedule) {
    sb_log_info(i18n_r(SB_SHORTNAME.'/RUNNING_SCHEDULED'), $schedule['name']);
    $data = sb_load();
    $source = $data['sources'][$schedule['source']];
    $destination = $data['destinations'][$schedule['destination']];
    $format = $schedule['archive_format'];
    $limit = $schedule['limit'];

    $result = sb_run_backup($source, $destination, $format, $limit);

    if (!$result) {
        sb_log_error(i18n_r(SB_SHORTNAME.'/ERROR_SCHEDULE'), array($schedule['name'], sb_get_error()));
    } else {
        sb_log_info(i18n_r(SB_SHORTNAME.'/SUCCESS_SCHEDULE'), $schedule['name']);
    }
    return $result;
}


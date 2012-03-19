<?php
function sb_upload_local($archive, $destination) {
    $archive_name = basename($archive);
    sb_ensure_directory_exists($destination['path']);
    if (!rename($archive, $destination['path'] . $archive_name)) {
        $error = i18n_r(SB_SHORTNAME.'/ERROR_FILEMOVE');
        sb_log_error($error, $destination['path']);
        sb_set_error($error, $destination['path']);
        return false;
    }
    return true;
}

function sb_local_backup_compare($a, $b) {
    $a = $a['mtime'];
    $b = $b['mtime'];
    return $a === $b ? 0 : ($a < $b ? -1 : 1);
}

function sb_clean_local($destination, $match_pattern, $limit) {
    $result = true;
    $backups = array();
    foreach (scandir($destination['path']) as $filename) {
        if (preg_match($match_pattern, $filename)) {
            $filename = $destination['path'] . $filename;
            $backups[$filename] = stat($filename);
        }
    }
    if (count($backups) > $limit) {
        uasort($backups, "sb_local_backup_compare");
        $filenames = array_keys($backups);
        $to_delete = count($backups) - $limit;
        for ($i = 0; $i < $to_delete; $i++) {
            unlink($filenames[$i]);
        }
    }
    return $result;
}



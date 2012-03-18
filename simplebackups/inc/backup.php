<?php
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
        sb_set_error("Unsupported format.");
        $result = False;
        break;
    }
    return $result;
}

function sb_create_targz($source, $exclude=Null) {
    $sb_config = sb_config();
    $tar = $sb_config['binaries']['tar'];
    $tempfile = sb_tempfile(sb_generate_name($source, ".tar.gz"));

    $source_path = $source['path'];

    $tar_options = " -czf $tempfile ";
    if ($exclude) {
        $exclude = rtrim($exclude, '/');
        $tar_options .= " --exclude " . str_replace($source_path, './', $exclude);
    }
    $tar_options .= " --exclude " . rtrim(str_replace($source_path, './', SB_BACKUPPATH), '/');
    $tar_options .= " --exclude " . rtrim(str_replace($source_path, './', SB_TEMPPATH), '/');
    $command = "cd " . $source_path . " && $tar $tar_options ./";
    error_log("exec - $command");

    $output = array();
    $retval = 0;
    exec($command, $output, $retval);
    if ($retval !== 0 && $retval !== 1) {
        @unlink($tempfile);
        sb_set_error("There was an error creating the .tar.gz.");
        return False;
    } else {
        return $tempfile;
    }
}

function sb_create_zip($source, $exclude=Null) {
    sb_set_error(".zip support not yet implemented.");
    return False;
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
        sb_set_error("Unsupported destination type.");
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

function sb_upload_ftp($archive, $destination) {
    sb_set_error("FTP support not yet implemented.");
    return False;
}

function sb_upload_s3($archive, $destination) {
    sb_set_error("S3 support not yet implemented.");
    return False;
}

function sb_upload_email($archive, $destination) {
    $from = defined("GSFROMEMAIL") ? GSFROMEMAIL : "noreply@get-simple.info";
    $result = sb_send_email($from, $destination['address'], $destination['subject'], SB_EMAIL_BODY, $archive);
    if (!$result) {
        sb_set_error("Error emailing '%s' to '%s'", array(basename($archive), $destination['name']));
        sb_log_error("Error emailing '%s' to '%s'", array(basename($archive), $destination['name']));
    } else {
        sb_log_info("Emailed '%s' to '%s'", array(basename($archive), $destination['name']));
    }
    return $result;
}

function sb_upload_local($archive, $destination) {
    $archive_name = basename($archive);
    sb_ensure_directory_exists($destination['path']);
    if (!rename($archive, $destination['path'] . $archive_name)) {
        sb_set_error("Unable to move backup to '".$destination['path']."'.");
        return false;
    }
    return true;
}

function sb_clean_backups($source, $destination, $format, $limit) {
    $match_pattern = sb_generate_pattern($source, $format);
    switch($destination['type']) {
    case "local":
        $result = sb_clean_local($destination, $match_pattern, $limit);
        break;
    case "email":
        $result = true;
        break;
    default:
        sb_set_error("Unsupported destination type.");
        $result = false;
        break;
    }
    return $result;
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


function sb_run_scheduled_backup($schedule) {
    sb_log_info("Running scheduled backup '%s'", $schedule['name']);
    $data = sb_load();
    $source = $data['sources'][$schedule['source']];
    $destination = $data['destinations'][$schedule['destination']];
    $format = $schedule['archive_format'];
    $limit = $schedule['limit'];

    $result = sb_run_backup($source, $destination, $format, $limit);

    if (!$result) {
        sb_log_error("Error running scheduled backup '%s': %s", array($schedule['name'], sb_get_error()));
    } else {
        sb_log_info("Scheduled backup '%s' run successfully.", $schedule['name']);
    }
    return $result;
}

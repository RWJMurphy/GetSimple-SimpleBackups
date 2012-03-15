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
        $result = False;
        break;
    }
    return $result;
}

function sb_create_targz($source, $exclude=Null) {
    $sb_config = sb_config();
    $tar = $sb_config['binaries']['tar'];
    $tempfile = sb_tempfile(sb_generate_name($source, ".tar.gz"));

    $relative_source_path = str_replace(GSROOTPATH, './', $source['path']);

    $tar_options = " -czf $tempfile ";
    if ($exclude) {
        $exclude = rtrim($exclude, '/');
        $tar_options .= " --exclude " . str_replace(GSROOTPATH, './', $exclude);
    }
    $tar_options .= " --exclude " . rtrim(str_replace(GSROOTPATH, './', SB_TEMPPATH), '/');
    $command = "cd " . GSROOTPATH . " && $tar $tar_options $relative_source_path";
    error_log("exec - $command");

    $output = array();
    $retval = 0;
    exec($command, $output, $retval);
    if ($retval !== 0 && $retval !== 1) {
        @unlink($tempfile);
        error_log("Retval was $retval, output: " . implode("\n", $output));
        return False;
    } else {
        return $tempfile;
    }
}

function sb_create_zip($source, $exclude=Null) {
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
    default:
        $result = False;
        break;
    }
    return $result;    
}

function sb_upload_ftp($archive, $destination) {
    return False;
}

function sb_upload_s3($archive, $destination) {
    return False;
}

function sb_upload_local($archive, $destination) {
    $archive_name = basename($archive);
    if (!file_exists($destination['path'])) { 
        mkdir($destination['path'], 0777, True);
    }
    return rename($archive, $destination['path'] . $archive_name);
}

function sb_clean_backups($source, $destination, $format, $limit) {
    $match_pattern = sb_generate_pattern($source, $format);
    switch($destination['type']) {
    case "local":
        $result = sb_clean_local($destination, $match_pattern, $limit);
        break;
    default:
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


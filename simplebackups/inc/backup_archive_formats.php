<?php
require_once SB_INCLUDEPATH.'/backup_archive_format_zip.php';

function sb_create_targz($source, $exclude=Null) {
    $sb_config = sb_config();
    $tar = $sb_config['binaries']['tar'];

    if (!sb_executable_exists($tar)) {
        sb_set_error(i18n_r(SB_SHORTNAME.'/ERROR_TAR_NOT_FOUND'));
        return false;
    }

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
    sb_log_debug("exec - $command");

    $output = array();
    $retval = 0;
    exec($command, $output, $retval);
    if ($retval !== 0 && $retval !== 1) {
        @unlink($tempfile);
        sb_set_error(i18n_r(SB_SHORTNAME.'/ERROR_TARGZ'));
        return False;
    } else {
        return $tempfile;
    }
}


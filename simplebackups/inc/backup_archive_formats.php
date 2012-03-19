<?php
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

function sb_create_zip($source, $exclude=Null) {
    $sb_config = sb_config();
    $zip = $sb_config['binaries']['zip'];

    if (!sb_executable_exists($zip)) {
        sb_set_error(i18n_r(SB_SHORTNAME.'/ERROR_ZIP_NOT_FOUND'));
        return false;
    }

    $tempfile = sb_tempfile(sb_generate_name($source, ".zip"));
    @unlink($tempfile); // since `zip' will refuse to operate on a zero-byte .zip file
    $source_path = $source['path'];

    $zip_options = " -r ";

    $zip_options .= "$tempfile ./ ";
    if ($exclude) {
        $zip_options .= " --exclude " . str_replace($source_path, './', $exclude) . "\*";
    }
    $zip_options .= " --exclude " . str_replace($source_path, './', SB_BACKUPPATH) . "\*";
    $zip_options .= " --exclude " . str_replace($source_path, './', SB_TEMPPATH) . "\*";
    $command = "cd " . $source_path . " && $zip $zip_options ";
    sb_log_debug("exec - $command");

    $output = array();
    $retval = 0;
    exec($command, $output, $retval);
    if ($retval !== 0) {
        @unlink($tempfile);
        sb_set_error(i18n_r(SB_SHORTNAME.'/ERROR_ZIP'));
        return False;
    } else {
        return $tempfile;
    }
}

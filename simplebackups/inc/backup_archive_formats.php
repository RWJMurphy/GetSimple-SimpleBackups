<?php
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
        sb_set_error(i18n_r(SB_SHORTNAME.'/ERROR_TARGZ'));
        return False;
    } else {
        return $tempfile;
    }
}

function sb_create_zip($source, $exclude=Null) {
    sb_set_error(i18n_r(SB_SHORTNAME.'/NOT_IMPLEMENTED'), "zip archive");
    return False;
}

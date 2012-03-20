<?php
function sb_create_zip($source, $exclude=Null) {
    if (class_exists('ZipArchive')) {
        return sb_create_zip_ziparchive($source, $exclude);
    } else {
        return sb_create_zip_binary($source, $exclude);
    }
}


function sb_create_zip_binary($source, $exclude=Null) {
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

function sb_create_zip_ziparchive($source, $exclude=Null) {
    $zip_archive = new ZipArchive();
    $tempfile = sb_tempfile(sb_generate_name($source, ".zip"));
    @unlink($tempfile);

    if($zip_archive->open($tempfile, ZipArchive::CREATE) !== True) {
        sb_set_error(i18n_r(SB_SHORTNAME.'/ERROR_ZIPARCHIVE_OPEN'));
        return false;
    }

    $excludes = array(SB_BACKUPPATH, SB_TEMPPATH);
    if ($exclude) {
        $excludes[] = $exclude;
    }

    $filenames = sb_recursive_dirscan($source['path'], $excludes);

    foreach($filenames as $filename) {
        $localname = str_replace($source['path'], '', $filename);
        $zip_archive->addFile($filename, $localname);
    }
    $zip_archive->close();
    return $tempfile;
}



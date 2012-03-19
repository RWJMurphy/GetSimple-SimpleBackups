<?php
function sb_validate_ftp($destination, $close=True) {
    $connection = ftp_connect($destination['host'], $destination['port']);
    if (!$connection) {
        sb_set_error(i18n_r(SB_SHORTNAME.'/FTP_CONNECT_FAILED'), $destination['name']);
        sb_log_error(i18n_r(SB_SHORTNAME.'/FTP_CONNECT_FAILED'), $destination['name']);
        return false;
    }

    $logged_in = @ftp_login($connection, $destination['username'], $destination['password']);
    if (!$logged_in) {
        sb_set_error(i18n_r(SB_SHORTNAME.'/FTP_LOGIN_FAILED'), $destination['name']);
        sb_log_error(i18n_r(SB_SHORTNAME.'/FTP_LOGIN_FAILED'), $destination['name']);
        if ($close) {
            ftp_close($connection);
        }
        return false;
    }

    if (!@ftp_chdir($connection, $destination['path'])) {
        sb_set_error(i18n_r(SB_SHORTNAME.'/FTP_CHDIR_FAILED'), $destination['name']);
        sb_log_error(i18n_r(SB_SHORTNAME.'/FTP_CHDIR_FAILED'), $destination['name']);
        if ($close) {
            ftp_close($connection);
        }
        return false;
    }

    if ($close) {
        ftp_close($connection);
        return true;
    } else {
        ftp_pasv($connection, true);
        return $connection;
    }
}

function sb_upload_ftp($archive, $destination) {
    $connection = sb_validate_ftp($destination, false);
    if (!$connection) {
        sb_set_error(i18n_r(SB_SHORTNAME.'/FTP_UPLOAD_FAILED'), $archive);
        return false;
    }

    $put_result = ftp_put($connection, basename($archive), $archive, FTP_BINARY);
    if (!$put_result) {
        sb_set_error(i18n_r(SB_SHORTNAME.'/FTP_UPLOAD_FAILED'), $archive);
    }
    ftp_close($connection);
    return $put_result;
}

function sb_clean_ftp($destination, $match_pattern, $limit) {
    $connection = sb_validate_ftp($destination, false);
    if (!$connection) {
        sb_set_error(i18n_r(SB_SHORTNAME.'/FTP_CLEAN_FAILED'), $destination['name']);
        return false;
    }

    $backups = array();
    $files = ftp_nlist($connection, '.');
    if ($files === false) {
        sb_set_error(i18n_r(SB_SHORTNAME.'/FTP_CLEAN_FAILED'), $destination['name']);
        return false;
    }

    $result = true;
    foreach($files as $filename) {
        if (preg_match($match_pattern, $filename)) {
            $backups[] = $filename;
        }
    }

    if(count($backups) > $limit) {
        sort($backups);
        $to_delete = count($backups) - $limit;
        for ($i = 0; $i < $to_delete; $i++) {
            $del_result = ftp_delete($connection, $backups[$i]);
            sb_log_debug("FTP delete - %s - %s - %s", array($destination['name'], $backups[$i], $del_result));
            $result &= $del_result;
        }
    }

    ftp_close($connection);
    return $result;
}

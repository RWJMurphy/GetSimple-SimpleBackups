<?php

function sb_add_destination($type, $postdata) {
    $destination = array();
    if (!$postdata['name']) {
        sb_set_error(i18n_r(SB_SHORTNAME.'/ERROR_VALID_NAME'));
    }
    $destination['name'] = $postdata['name'];
    $destination['type'] = $type;
    switch($type) {
    case "local":
        if (!$postdata['local_path']) {
            sb_set_error(i18n_r(SB_SHORTNAME.'/ERROR_VALID_LOCAL_PATH'));
        }
        $destination['path'] = sb_path_trailing_slash($postdata['local_path']);
        break;
    case "ftp":
        if (!$postdata['ftp_host']) {
            sb_set_error(i18n_r(SB_SHORTNAME.'/ERROR_VALID_FTP_HOSTNAME'));
        }
        if (!$postdata['ftp_port']) {
            $postdata['ftp_port'] = SB_FTP_PORT_DEFAULT;
        } elseif ($postdata['ftp_port'] <= 0 || $postdata['ftp_port'] > 65535) {
            sb_set_error(i18n_r(SB_SHORTNAME.'/ERROR_VALID_FTP_PORT'));
        }

        $destination['host'] = $postdata['ftp_host'];
        $destination['username'] = $postdata['ftp_username'];
        $destination['password'] = $postdata['ftp_password'];
        $destination['port'] = $postdata['ftp_port'];
        $destination['path'] = sb_path_trailing_slash($postdata['ftp_path']);
        sb_validate_ftp($destination);
        break;
    case "s3":
        if (!$postdata['s3_bucket']) {
            sb_set_error(i18n_r(SB_SHORTNAME.'/ERROR_VALID_S3_BUCKET'));
        }
        if (!$postdata['s3_access_key_id']) {
            sb_set_error(i18n_r(SB_SHORTNAME.'/ERROR_VALID_S3_KEY'));
        }
        if (!$postdata['s3_access_key_secret']) {
            sb_set_error(i18n_r(SB_SHORTNAME.'/ERROR_VALID_S3_SECRET'));
        }

        $destination['bucket'] = $postdata['s3_bucket'];
        $destination['access_key_id'] = $postdata['s3_access_key_id'];
        $destination['access_key_secret'] = $postdata['s3_access_key_secret'];
        $destination['path'] = sb_path_trailing_slash($postdata['s3_path']);
        sb_validate_s3($destination);
        break;
    case "email":
        if (!$postdata['email_address']) {
            sb_set_error(i18n_r(SB_SHORTNAME.'/ERROR_VALID_EMAIL_ADDRESS'));
        }
        if (!$postdata['email_subject']) {
            sb_set_error(i18n_r(SB_SHORTNAME.'/ERROR_VALID_EMAIL_SUBJECT'));
        }
        $destination['address'] = $postdata['email_address'];
        $destination['subject'] = $postdata['email_subject'];
        break;
    default:
        sb_set_error(i18n_r(SB_SHORTNAME.'/ERROR_VALID_TYPE'));
        break;
    }

    if (sb_has_error()) {
        return false;
    }

    $destinations = sb_load_thing("destinations");
    $destinations[] = $destination;

    $result = sb_save_thing("destinations", $destinations);
    if (!$result) {
        sb_set_error(i18n_r(SB_SHORTNAME.'/ERROR_SAVING_DESTINATION'));
    }
    return $result;
}

function sb_delete_destination($id) {
    $destinations = sb_load_thing("destinations");
    unset($destinations[$id]);
    $result = sb_save_thing("destinations", $destinations);
    if (!$result) {
        sb_set_error(i18n_r(SB_SHORTNAME.'/ERROR_DELETING_DESTINATION'));
    }
    return $result;
}


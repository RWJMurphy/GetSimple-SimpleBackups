<?php
function sb_load() {
    $data = array();
    $sb_config = sb_config();
    foreach (array_keys($sb_config['xml']) as $thing) {
        $data[$thing] = sb_load_thing($thing);
    }
    return $data;
}

function sb_load_thing($thing) {
    sb_ensure_directory_exists(SB_XMLPATH);
    $sb_config = sb_config();
    $data = array();
    $xml_filename = $sb_config['xml'][$thing];

    if (file_exists($xml_filename)) {
        $xml = getXML($xml_filename);
        foreach ($xml->children() as $thing_instance_xml) {
            $thing_instance = array();
            foreach($thing_instance_xml->children() as $child) {
                $thing_instance[$child->getName()] = (string)$child;
            }
            $data[(string)$thing_instance_xml['id']] = $thing_instance;
        }
    } else {
        if (array_key_exists($thing, $sb_config['default_settings'])) {
            $data = $sb_config['default_settings'][$thing];
        }
    }
    return $data;
}

function sb_save_thing($thing, $data) {
    sb_ensure_directory_exists(SB_XMLPATH);
    $sb_config = sb_config();
    $xml_filename = $sb_config['xml'][$thing];

    $plural_thing = $thing . "s";
    $xml = @new SimpleXMLElement("<$plural_thing></$plural_thing>");
    foreach($data as $id => $thing_instance) {
        $child = $xml->addChild($thing);
        foreach($thing_instance as $attr => $value) {
            $child->addChild($attr, $value);
        }
        $child->addAttribute("id", $id);
    }

    return $xml->asXML($xml_filename);
}


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

function sb_add_source($type, $postdata) {
    $source = array();
    if (!$postdata['name']) {
        sb_set_error(i18n_r(SB_SHORTNAME.'/ERROR_VALID_NAME'));
    }
    $source['name'] = $postdata['name'];
    $source['type'] = $type;
    switch($type) {
    case "local":
        if (!$postdata['local_path']) {
            sb_set_error(i18n_r(SB_SHORTNAME.'/ERROR_VALID_LOCAL_PATH'));
        }
        $source['path'] = sb_path_trailing_slash($postdata['local_path']);
        break;
    default:
        sb_set_error(i18n_r(SB_SHORTNAME.'/ERROR_VALID_TYPE'));
        break;
    }

    if (sb_has_error()) {
        return false;
    }

    $sources = sb_load_thing("sources");
    $sources[] = $source;

    $result = sb_save_thing("sources", $sources);
    if (!$result) {
        sb_set_error(i18n_r(SB_SHORTNAME.'/ERROR_SAVING_SOURCE'));
    }
    return $result;
}

function sb_delete_source($id) {
    $sources = sb_load_thing("sources");
    unset($sources[$id]);
    $result = sb_save_thing("sources", $sources);
    if (!$result) {
        sb_set_error(i18n_r(SB_SHORTNAME.'/ERROR_DELETING_SOURCE'));
    }
    return $result;
}

function sb_add_schedule($postdata) {
    $schedule = array();
    $data = sb_load();

    if (!$postdata['name']) {
        sb_set_error(i18n_r(SB_SHORTNAME.'/ERROR_VALID_NAME'));
    }
    if (!$postdata['frequency']) {
        sb_set_error(i18n_r(SB_SHORTNAME.'/ERROR_VALID_FREQUENCY'));
    }
    if ($postdata['limit'] !== "" && intval($postdata['limit']) <= 0) {
        sb_set_error(i18n_r(SB_SHORTNAME.'/ERROR_VALID_LIMIT'));
    }
    if (!array_key_exists($postdata['source'], $data['sources'])) {
        sb_set_error(i18n_r(SB_SHORTNAME.'/ERROR_VALID_SOURCE'));
    }
    if (!array_key_exists($postdata['destination'], $data['destinations'])) {
        sb_set_error(i18n_r(SB_SHORTNAME.'/ERROR_VALID_DESTINATION'));
    }
    if (!in_array($postdata['archive_format'], $data['archive_formats'])) {
        sb_set_error(i18n_r(SB_SHORTNAME.'/ERROR_VALID_ARCHIVE_FORMAT'));
    }
    $schedule['name'] = $postdata['name'];
    $schedule['frequency'] = $postdata['frequency'];
    $schedule['limit'] = intval($postdata['limit']);
    $schedule['source'] = intval($postdata['source']);
    $schedule['destination'] = intval($postdata['destination']);
    $schedule['archive_format'] = $postdata['archive_format'];

    if (sb_has_error()) {
        return false;
    }

    $schedules = $data['schedules'];
    $schedules[] = $schedule;
    $result = sb_save_thing("schedules", $schedules);
    if (!$result) {
        sb_set_error(i18n_r(SB_SHORTNAME.'/ERROR_SAVING_SCHEDULE'));
    }
    return $result;
}

function sb_delete_schedule($id) {
    $schedules = sb_load_thing("schedules");
    unset($schedules[$id]);
    $result = sb_save_thing("schedules", $schedules);
    if (!$result) {
        sb_set_error(i18n_r(SB_SHORTNAME.'/ERROR_DELETING_SCHEDULE'));
    }
    return $result;
}

function sb_update_schedule($id, $schedule) {
    $schedules = sb_load_thing("schedules");
    $schedules[$id] = $schedule;
    $result = sb_save_thing("schedules", $schedules);
    if (!$result) {
        $error = i18n_r(SB_SHORTNAME.'/ERROR_UPDATING_SCHEDULE');
        sb_set_error($error, $schedule['name']);
        sb_log_error($error, $schedule['name']);
    }
    return $result;
}


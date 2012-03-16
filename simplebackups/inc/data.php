<?php
function sb_load() {
    $data = array();
    foreach (array("sources", "destinations", "schedules", "archive_formats", "last_run") as $thing) {
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
            $data[] = $thing_instance;
        }
    } else {
        $data = $sb_config['default_settings'][$thing];
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
    }

    return $xml->asXML($xml_filename);
}


function sb_add_destination($type, $postdata) {
    $destination = array();
    if (!$postdata['name']) {
        sb_set_error("You must supply a name.");
    }
    $destination['name'] = $postdata['name'];
    $destination['type'] = $type;
    switch($type) {
    case "local":
        if (!$postdata['local_path']) {
            sb_set_error("You must supply a local path.");
        }
        $destination['path'] = sb_path_trailing_slash($postdata['local_path']);
        break;
    case "ftp":
        if (!$postdata['ftp_host']) {
            sb_set_error("You must supply a hostname for the FTP server.");
        }
        if (!$postdata['ftp_port']) {
            $postdata['ftp_port'] = SB_FTP_PORT_DEFAULT;
        } elseif ($postdata['ftp_port'] <= 0 || $postdata['ftp_port'] > 65535) {
            sb_set_error("Invalid FTP port.");
        }
        $destination['host'] = $postdata['ftp_host'];
        $destination['username'] = $postdata['ftp_username'];
        $destination['password'] = $postdata['ftp_password'];
        $destination['port'] = $postdata['ftp_port'];
        $destination['path'] = sb_path_trailing_slash($postdata['ftp_path']);
        break;
    case "s3":
        if (!$postdata['s3_bucket']) {
            sb_set_error("You must supply a bucket name.");
        }
        if (!$postdata['s3_access_key_id']) {
            sb_set_error("You must supply an Access Key ID.");
        }
        if (!$postdata['s3_access_key_secret']) {
            sb_set_error("You must supply an Access Key Secret.");
        }

        $destination['bucket'] = $postdata['s3_bucket'];
        $destination['access_key_id'] = $postdata['s3_access_key_id'];
        $destination['access_key_secret'] = $postdata['s3_access_key_secret'];
        $destination['path'] = sb_path_trailing_slash($postdata['s3_path']);
        break;
    case "email":
        if (!$postdata['email_address']) {
            sb_set_error("You must supply an email address.");
        }
        if (!$postdata['email_subject']) {
            sb_set_error("You must supply a subject line.");
        }
        $destination['address'] = $postdata['email_address'];
        $destination['subject'] = $postdata['email_subject'];
        break;
    default:
        break;
    }

    if (sb_has_error()) {
        return false;
    }

    $destinations = sb_load_thing("destinations");
    $destinations[] = $destination;


    $result = sb_save_thing("destinations", $destinations);
    if (!$result) {
        sb_set_error("There was an error saving destination data.");
    }
    return $result;
}

function sb_delete_destination($id) {
    $destinations = sb_load_thing("destinations");
    unset($destinations[$id]);
    $result = sb_save_thing("destinations", $destinations);
    if (!result) {
        sb_set_error("There was an error deleting the destination.");
    }
    return $result;
}


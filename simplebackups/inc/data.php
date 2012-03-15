<?php
function sb_load() {
    $data = array();
    foreach (array("sources", "destinations", "schedules", "archive_formats", "last_run") as $thing) {
        $data[$thing] = sb_load_thing($thing);
    }
    return $data;
}

function sb_load_thing($thing) {
    $sb_config = sb_config();
    $data = array();
    $xml_filename = $sb_config['xml'][$thing];

    if (file_exists($xml_filename) && false) {
        // TODO load into $data
    } else {
        $data = $sb_config['default_settings'][$thing];
    }
    return $data;
}

function sb_save_thing($thing, $data) {
    // TODO: this
    return false;
    $sb_config = sb_config();
    $xml_filename = $sb_config['xml'][$thing];

    $xml = @new SimpleXMLElement("<$thing><$thing/>");

    return $xml->asXML($xml_filename);
}

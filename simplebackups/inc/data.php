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

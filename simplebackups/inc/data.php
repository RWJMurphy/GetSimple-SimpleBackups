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
        $xml = sb_load_xml_file($xml_filename);
        foreach ($xml->children() as $thing_instance_xml) {
            $thing_instance = array();
            foreach($thing_instance_xml->children() as $child) {
                $thing_instance[$child->getName()] = html_entity_decode((string)$child, ENT_QUOTES, 'UTF-8');
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
    $xml = @new SimpleXMLExtended("<$plural_thing></$plural_thing>");
    foreach($data as $id => $thing_instance) {
        $child = $xml->addChild($thing);
        foreach($thing_instance as $attr => $value) {
            $value = htmlentities($value, ENT_QUOTES, 'UTF-8');
            $elem = $child->addChild($attr);
            $elem->addCData($value);
        }
        $child->addAttribute("id", $id);
    }

    return XMLsave($xml, $xml_filename);
}

function sb_load_xml_file($filename, $fallback=true) {
    $xml = Null;
    $errors = array();
    try {
        libxml_use_internal_errors(true);
        $xml = new SimpleXMLExtended(file_get_contents($filename));
    } catch (Exception $e) {
        if ($fallback) {
            $backup_filename = $filename . ".bak";
            sb_log_warning(i18n_r(SB_SHORTNAME.'/XML_LOAD_FALLBACK'), array($filename, $backup_filename));
            copy($filename, $backup_filename);
            try {
                // First, try converting named entites into numeric, and reload
                $xml = new SimpleXMLExtended(html_convert_entities(file_get_contents($filename)));
                sb_log_warning(i18n_r(SB_SHORTNAME.'/XML_FALLBACK_ENTITY') ,$filename);
                $xml->asXML($filename);
            } catch (Exception $e) {
                // Still no love? Try DOMDocument in with recover = true
                // We'll probably lose some data, but at least we can continue.
                if (class_exists('DOMDocument')) {
                    $domdoc = new DOMDocument;
                    $domdoc->substituteEntities = true;
                    $domdoc->recover = true;
                    $domdoc->loadXML(file_get_contents($filename));
                    $xml = new SimpleXMLExtended($domdoc->saveXML());
                    sb_log_warning(i18n_r(SB_SHORTNAME.'/XML_FALLBACK_DOMDOCUMENT'), $filename);
                    $xml->asXML($filename);
                }
            }
        }
    }

    $libxml_errors = libxml_get_errors();
    if (count($libxml_errors) >0) {
        $errors = array();
        foreach($libxml_errors as $error) {
            $errors[] = $error->message;
        }
        $error_string = implode(" | ", $errors);

        sb_set_error(i18n_r(SB_SHORTNAME.'/XML_LOAD_FAILED'), array($filename, $error_string));
    }
    return $xml;
}

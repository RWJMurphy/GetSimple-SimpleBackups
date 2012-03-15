<?php
function sb_link($action=Null) {
    $link = "?id=" . SB_SHORTNAME;
    if ($action) {
        $link .= "&action=$action";
    }
    return $link;
}

function sb_is_current_action($action) {
    $sb_config = sb_config();
    return (
        (isset($_GET['action']) && $_GET['action'] == $action) or
        (!isset($_GET['action']) && $sb_config['default_action'] == $action)
    );
}

function sb_tempfile($filename) {
    $path = SB_TEMPPATH;
    if (!file_exists($path)) {
        mkdir($path, 0777, True);
    }
    $filename = $path . $filename;
    touch($filename);
    return $filename;
}

function sb_generate_name($source, $format) {
    $filename = preg_replace('/[^a-z0-9_\-]/', '_', strtolower($source['name']));
    $filename .= date("_YmdHis");
    $filename .= $format;
    return $filename;
}

function sb_generate_pattern($source, $format) {
    $pattern = "/^";
    $pattern .= preg_replace('/[^a-z0-9_\-]/', '_', strtolower($source['name']));
    $pattern .= "_[0-9]{14}";
    $pattern .= str_replace('.', '\.', $format);
    $pattern .= "/";
    return $pattern;
}

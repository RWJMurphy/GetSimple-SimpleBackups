<?php
function sb_link($action=Null, $target=Null) {
    $link = "?id=" . SB_SHORTNAME;
    if ($action !== Null) {
        $link .= "&$action";
    }
    if ($target !== Null) {
        $link .= "&target=$target";
    }
    return $link;
}

function sb_is_current_action($action) {
    return $action == sb_current_action();
}

function sb_current_action() {
    $sb_config = sb_config();
    $selected_action = Null;
    foreach ($sb_config['actions'] as $action) {
        if (isset($_GET[$action])) {
            $selected_action = $action;
            break;
        }
    }
    $selected_action = $selected_action ? $selected_action : $sb_config['default_action'];
    return $selected_action;
}

function sb_tempfile($filename) {
    $path = SB_TEMPPATH;
    sb_ensure_directory_exists($path);
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

function sb_set_error($message) {
    global $sb_errors;
    if (!isset($sb_errors)) {
        $sb_errors = array();
    }

    $sb_errors[] = $message;
}

function sb_get_errors() {
    global $sb_errors;
    if (!isset($sb_errors)) {
        $sb_errors = array();
    }

    $glue = "\n";
    return implode($glue, $sb_errors);
}

function sb_has_error() {
    global $sb_errors;
    return (isset($sb_errors) && count($sb_errors) > 0);
}

function sb_ensure_directory_exists($path) {
    if (!file_exists($path)) {
        return mkdir($path, 0777, true);
    }
    return True;
}

function sb_path_trailing_slash($path) {
    if ($path == "" || $path[strlen($path)-1] != '/') {
        return $path . "/";
    }
    return $path;
}

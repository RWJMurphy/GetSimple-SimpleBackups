<?php
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


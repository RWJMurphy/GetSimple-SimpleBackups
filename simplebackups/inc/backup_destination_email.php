<?php
function sb_upload_email($archive, $destination) {
    $from = defined("GSFROMEMAIL") ? GSFROMEMAIL : "noreply@get-simple.info";
    $result = sb_send_email($from, $destination['address'], $destination['subject'], i18n_r(SB_SHORTNAME.'/EMAIL_BODY'), $archive);
    if (!$result) {
        $error = i18n_r(SB_SHORTNAME.'/ERROR_EMAIL');
        sb_set_error($error, $array(basename($archive), $destination['name']));
        sb_log_error($error, $array(basename($archive), $destination['name']));
    } else {
        sb_log_info(i18n_r(SB_SHORTNAME.'/SUCCESS_EMAIL'), array(basename($archive), $destination['name']));
    }
    return $result;
}

function sb_clean_email($destination, $match_pattern, $limit) {
    sb_set_error(i18n_r(SB_SHORTNAME.'/NOT_IMPLEMENTED'), "email");
    return False;
}

<?php
function sb_upload_s3($archive, $destination) {
    sb_set_error(i18n_r(SB_SHORTNAME.'/NOT_IMPLEMENTED'), "S3");
    return False;
}

function sb_clean_s3($destination, $match_pattern, $limit) {
    sb_set_error(i18n_r(SB_SHORTNAME.'/NOT_IMPLEMENTED'), "S3");
    return False;
}

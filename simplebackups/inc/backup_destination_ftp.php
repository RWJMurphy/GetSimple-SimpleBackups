<?php
function sb_upload_ftp($archive, $destination) {
    sb_set_error(i18n_r(SB_SHORTNAME.'/NOT_IMPLEMENTED'), "FTP");
    return False;
}

function sb_clean_ftp($destination, $match_pattern, $limit) {
    sb_set_error(i18n_r(SB_SHORTNAME.'/NOT_IMPLEMENTED'), "FTP");
    return False;
}

<?php
$result = sb_delete_all_logs();
$redirect = "logs";
if (!$result) {
    $message_class = "error";
    $message = sb_get_errors();
} else {
    $message_class = "success";
    $message = i18n_r(SB_SHORTNAME.'/SUCCESS_DELETE_ALL_LOGS');
}
redirect(sb_link($redirect) . "&$message_class=" . urlencode($message));
exit;

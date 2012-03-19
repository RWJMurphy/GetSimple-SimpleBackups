<?php
$target = isset($_POST['target']) ? $_POST['target'] : (isset($_GET['target']) ? $_GET['target'] : Null);
$result = sb_delete_log($target);
$redirect = "logs";
if (!$result) {
    $message_class = "error";
    $message = sb_get_errors();
} else {
    $message_class = "success";
    $message = i18n_r(SB_SHORTNAME.'/SUCCESS_DELETE_LOG');
}
redirect(sb_link($redirect) . "&$message_class=" . urlencode($message));
exit;

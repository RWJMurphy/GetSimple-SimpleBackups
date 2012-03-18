<?php
$result = sb_delete_all_logs($target);
$redirect = "logs";
if (!$result) {
    $message_class = "error";
    $message = sb_get_errors();
} else {
    $message_class = "success";
    $message = "All logs deleted!";
}
redirect(sb_link($redirect) . "&$message_class=" . urlencode($message));
exit;

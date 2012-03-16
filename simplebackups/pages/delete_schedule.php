<?php
$target = isset($_POST['target']) ? $_POST['target'] : (isset($_GET['target']) ? $_GET['target'] : Null);
$result = sb_delete_schedule($target);
$redirect = "schedules";
if (!$result) {
    $message_class = "error";
    $message = sb_get_errors();
} else {
    $message_class = "success";
    $message = "Schedule deleted!";
}
redirect(sb_link($redirect) . "&$message_class=" . urlencode($message));
exit;

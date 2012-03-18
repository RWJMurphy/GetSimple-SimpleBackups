<h2>Logs</h2>
<table class="logs">
    <tbody>
        <tr>
            <th class="time">Time</th>
            <th class="level">Level</th>
            <th class="message">Message</th>
            <th></th>
        </tr>
<?php
$logs = sb_get_logs(SB_LOG_INFO);
foreach ($logs as $key => $log) {
    $timestamp = date(SB_LOG_TIMEFORMAT, $log['timestamp']);
    $message = $log['message'];
    switch($log['level']) {
    case(SB_LOG_DEBUG):
        $level = "debug";
        break;
    case(SB_LOG_INFO):
        $level = "info";
        break;
    case(SB_LOG_WARNING):
        $level = "warning";
        break;
    case(SB_LOG_ERROR):
        $level = "error";
        break;
    case(SB_LOG_CRITICAL):
        $level = "critical";
        break;
    default:
        $level = "???";
        break;
    }
?>
        <tr>
            <td class="posttitle"><?php echo $timestamp; ?></td>
            <td><?php echo $level; ?></td>
            <td><?php echo $message; ?></td>
            <td class="delete"><a class="delconfirm" href="<?php echo sb_link("delete_log", $key); ?>" title="Delete log: <?php echo "$timestamp - $message"; ?>">X</a></td>
            <td class="indexColumn" style="display: none;"><?php echo "$timestamp $message"; ?></td>
        </tr>
<?php } ?>
    </tbody>
</table>

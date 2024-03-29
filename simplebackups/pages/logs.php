<h2><?php i18n(SB_SHORTNAME.'/LOGS'); ?></h2>
<form id="logs">
    <label for="level">Show logs with level 
    <select name="level">
        <option value="<?php echo SB_LOG_DEBUG; ?>"><?php i18n(SB_SHORTNAME.'/LOG_DEBUG'); ?></option>
        <option value="<?php echo SB_LOG_INFO; ?>" selected="selected"><?php i18n(SB_SHORTNAME.'/LOG_INFO'); ?></option>
        <option value="<?php echo SB_LOG_WARNING; ?>"><?php i18n(SB_SHORTNAME.'/LOG_WARNING'); ?></option>
        <option value="<?php echo SB_LOG_ERROR; ?>"><?php i18n(SB_SHORTNAME.'/LOG_ERROR'); ?></option>
        <option value="<?php echo SB_LOG_CRITICAL; ?>"><?php i18n(SB_SHORTNAME.'/LOG_CRITICAL'); ?></option>
    </select> or higher.</label>
</form>
<table class="logs">
    <tbody>
        <tr>
            <th class="time"><?php i18n(SB_SHORTNAME.'/TIMESTAMP'); ?></th>
            <th class="level"><?php i18n(SB_SHORTNAME.'/LEVEL'); ?></th>
            <th class="message"><?php i18n(SB_SHORTNAME.'/MESSAGE'); ?></th>
            <th></th>
        </tr>
<?php
$logs = sb_get_logs();
foreach ($logs as $key => $log) {
    $timestamp = date(SB_LOG_TIMEFORMAT, $log['timestamp']);
    $message = htmlspecialchars($log['message']);
    switch($log['level']) {
    case(SB_LOG_DEBUG):
        $level = i18n_r(SB_SHORTNAME.'/LOG_DEBUG');
        break;
    case(SB_LOG_INFO):
        $level = i18n_r(SB_SHORTNAME.'/LOG_INFO');
        break;
    case(SB_LOG_WARNING):
        $level = i18n_r(SB_SHORTNAME.'/LOG_WARNING');
        break;
    case(SB_LOG_ERROR):
        $level = i18n_r(SB_SHORTNAME.'/LOG_ERROR');
        break;
    case(SB_LOG_CRITICAL):
        $level = i18n_r(SB_SHORTNAME.'/LOG_CRITICAL');
        break;
    default:
        $level = i18n_r(SB_SHORTNAME.'/LOG_UNKNOWN');
        break;
    }
?>
        <tr data-level="<?php echo $log['level']; ?>" class="logline">
            <td class="posttitle"><?php echo $timestamp; ?></td>
            <td><?php echo $level; ?></td>
            <td><?php echo $message; ?></td>
            <td class="delete"><a class="delconfirm" href="<?php echo sb_link("delete_log", $key); ?>" title="<?php i18n(SB_SHORTNAME.'/DELETE_LOG');?>: <?php echo "$timestamp - $message"; ?>">X</a></td>
            <td class="indexColumn" style="display: none;"><?php echo "$timestamp $message"; ?></td>
        </tr>
<?php } ?>
    </tbody>
</table>

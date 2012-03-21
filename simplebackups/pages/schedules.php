<?php
$data = sb_load();
?>
<h2><?php i18n(SB_SHORTNAME.'/SCHEDULES'); ?></h2>
<table>
    <tbody>
        <tr>
            <th><?php i18n(SB_SHORTNAME.'/NAME'); ?></th>
            <th><?php i18n(SB_SHORTNAME.'/FREQUENCY'); ?></th>
            <th><?php i18n(SB_SHORTNAME.'/SOURCE'); ?></th>
            <th><?php i18n(SB_SHORTNAME.'/DESTINATION'); ?></th>
            <th><?php i18n(SB_SHORTNAME.'/LIMIT'); ?></th>
            <th><?php i18n(SB_SHORTNAME.'/LAST_RUN'); ?></th>
            <th></th>
        </tr>
<?php
foreach ($data['schedules'] as $key => $schedule) {
    $name = htmlspecialchars($schedule['name']);
    $frequency = $schedule['frequency'];
    $last_run_time = isset($schedule['last_run_time']) ? date(SB_LOG_TIMEFORMAT, $schedule['last_run_time']) : "never";
    $last_run_status = Null;
    if (isset($schedule['last_run_status'])) {
        $last_run_status = $schedule['last_run_status'] ? "success" : "failed";
    }
    $last_run = "$last_run_time: $last_run_status";

    $source = htmlspecialchars($data['sources'][$schedule['source']]['name']);
    $limit = htmlspecialchars($schedule['limit']);
    $destination = htmlspecialchars($data['destinations'][$schedule['destination']]['name']);
?>
        <tr>
            <td class="posttitle"><a title="<?php i18n(SB_SHORTNAME.'/EDIT_SCHEDULE'); ?>: <?php echo $name; ?>" href="<?php echo sb_link("edit_schedule", $key); ?>"><?php echo $name; ?></a></td>
            <td><?php echo $frequency; ?></td>
            <td><?php echo $source; ?></td>
            <td><?php echo $destination; ?></td>
            <td><?php echo $limit; ?></td>
            <td><?php echo $last_run; ?></td>
            <td class="delete"><a class="delconfirm" href="<?php echo sb_link("delete_schedule", $key); ?>" title="<?php i18n(SB_SHORTNAME.'/DELETE_SCHEDULE'); ?>: <?php echo $name; ?>">X</a></td>
            <td class="indexColumn" style="display: none;"><?php echo "$name $frequency $last_run"; ?></td>
        </tr>
<?php } ?>
    </tbody>
</table>

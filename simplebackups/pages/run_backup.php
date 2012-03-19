<?php
$data = sb_load();
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $source = $data['sources'][$_POST['source']];
    $destination = $data['destinations'][$_POST['destination']];
    $format = $_POST['format'];
    $limit = intval($_POST['limit']);
    $limit = $limit <= 0 ? null : $limit;

    sb_save_thing("last_run", array(array(
        "source" => $_POST['source'],
        "destination" => $_POST['destination'],
        "limit" => $limit,
        "archive_format" => $format
    )));

    $result = sb_run_backup($source, $destination, $format, $limit);
    if ($result) {
        $message = "Backup successful!";
        $message_class = "success";
    } else {
        $message = sb_get_errors();
        $message_class = "error";
    }
    redirect(sb_link("run_backup") . "&$message_class=" . urlencode($message));
    exit;
}

$last = $data['last_run'][0];
?>
<h2><?php i18n(SB_SHORTNAME.'/RUN_BACKUP_NOW'); ?></h2>
<form action="<?php echo sb_link("run_backup"); ?>" method="POST">
<?php i18n(SB_SHORTNAME.'/BACKUP'); ?>
<select name="source">
    <option value="" disabled="disabled"><?php i18n(SB_SHORTNAME.'/SOURCE'); ?></option>
<?php foreach($data['sources'] as $key => $source): ?>
    <option <?php if ($last['source'] == $key) { echo 'selected="selected" '; } ?> value="<?php echo $key; ?>" ><?php echo $source['name']; ?></option>
<?php endforeach; ?>
</select>
<?php i18n(SB_SHORTNAME.'/TO'); ?>
<select name="destination">
    <option value="" disabled="disabled"><?php i18n(SB_SHORTNAME.'/DESTINATION'); ?></option>
<?php foreach($data['destinations'] as $key => $destination): ?>
    <option <?php if ($last['destination'] == $key) { echo 'selected="selected" '; } ?> value="<?php echo $key; ?>" ><?php echo $destination['name']; ?></option>
<?php endforeach; ?>
</select>
<?php i18n(SB_SHORTNAME.'/AS'); ?>
<select name="format">
    <option value="" disabled="disabled"><?php i18n(SB_SHORTNAME.'/ARCHIVE_FORMAT'); ?></option>
<?php foreach($data['archive_formats'] as $format): ?>
    <option <?php if ($last['archive_format'] == $format) { echo 'selected="selected" '; } ?> value="<?php echo $format; ?>" ><?php echo $format; ?></option>
<?php endforeach; ?>
</select>,<?php i18n(SB_SHORTNAME.'/KEEPING'); ?> <input name="limit" size="2" <?php if ($last['limit']) { echo 'value="' . $last['limit'] . '" '; } ?> /> <?php i18n(SB_SHORTNAME.'/BACKUPS'); ?>.

<input type="submit" value="<?php i18n(SB_SHORTNAME.'/GO!'); ?>" />
</form>

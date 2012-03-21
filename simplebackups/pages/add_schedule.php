<?php
$data = sb_load();
$sb_config = sb_config();
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $_SESSION['add_schedule'] = $_POST;
    $result = sb_add_schedule($_POST);
    if (!$result) {
        $redirect = "add_schedule";
        $message_class = "error";
        $message = sb_get_errors();
    } else {
        unset($_SESSION['add_schedule']);
        $redirect = "schedules";
        $message_class = "success";
        $message = i18n_r(SB_SHORTNAME.'/SUCCESS_ADD_SCHEDULE');
    }
    $url = sb_link($redirect) . "&$message_class=" . urlencode($message);
    redirect($url);
    exit;
}

if (!isset($_SESSION['add_schedule']['frequency'])) {
    if (!isset($_SESSION['add_schedule'])) {
        $_SESSION['add_schedule'] = array();
    }
    $_SESSION['add_schedule']['frequency'] = "daily";
}
?>
<h2><?php i18n(SB_SHORTNAME.'/ADD_SCHEDULE'); ?></h2>
<form id="add" action="<?php echo sb_link("add_schedule"); ?>" method="POST">
    <p><label for="name"><?php i18n(SB_SHORTNAME.'/NAME'); ?>:</label><input class="text" name="name" value="<?php if (isset($_SESSION['add_schedule']['name'])) { echo htmlspecialchars($_SESSION['add_schedule']['name']); } ?>" /></p>
    <p><label for="frequency"><?php i18n(SB_SHORTNAME.'/FREQUENCY'); ?>:</label><select class="text" name="frequency">
        <option disabled="disabled"><?php i18n(SB_SHORTNAME.'/FREQUENCY'); ?></option>
<?php foreach($sb_config['schedule_frequencies'] as $frequency => $name) { ?>
<option <?php if (isset($_SESSION['add_schedule']['frequency']) && $_SESSION['add_schedule']['frequency'] == $frequency) { echo 'selected="selected" '; } ?> value="<?php echo $frequency; ?>"><?php echo htmlspecialchars($name);; ?></option>
<?php } ?>
    </select></p>
    <p><label for="limit"><?php i18n(SB_SHORTNAME.'/BACKUP_LIMIT'); ?>:</label><input class="text" name="limit" value="<?php if (isset($_SESSION['add_schedule']['limit'])) { echo htmlspecialchars($_SESSION['add_schedule']['limit']); } ?>" /></p>
    <p><label for="source"><?php i18n(SB_SHORTNAME.'/SOURCE'); ?>:</label><select class="text" name="source">
    <option disabled="disabled"><?php i18n(SB_SHORTNAME.'/SOURCE'); ?></option>
<?php foreach ($data['sources'] as $id => $source) { ?>
    <option <?php if (isset($_SESSION['add_schedule']['source']) && $_SESSION['add_schedule']['source'] == $id) { echo 'selected="selected" '; } ?> value="<?php echo $id; ?>"><?php echo htmlspecialchars($source['name']); ?></option>
<?php } ?>
    </select></p>
    <p><label for="destination"><?php i18n(SB_SHORTNAME.'/DESTINATION'); ?>:</label><select class="text" name="destination">
    <option disabled="disabled"><?php i18n(SB_SHORTNAME.'/DESTINATION'); ?></option>
<?php foreach ($data['destinations'] as $id => $destination) { ?>
    <option <?php if (isset($_SESSION['add_schedule']['destination']) && $_SESSION['add_schedule']['destination'] == $id) { echo 'selected="selected" '; } ?> value="<?php echo $id; ?>"><?php echo htmlspecialchars($destination['name']); ?></option>
<?php } ?>
    </select></p>
    <p><label for="archive_format"><?php i18n(SB_SHORTNAME.'/ARCHIVE_FORMAT'); ?>:</label><select class="text" name="archive_format">
    <option disabled="disabled"><?php i18n(SB_SHORTNAME.'/ARCHIVE_FORMAT'); ?></option>
<?php foreach ($data['archive_formats'] as $format) { ?>
    <option <?php if (isset($_SESSION['add_schedule']['archive_format']) && $_SESSION['add_schedule']['archive_format'] == $format) { echo 'selected="selected" '; } ?> value="<?php echo htmlspecialchars($format); ?>"><?php echo htmlspecialchars($format); ?></option>
<?php } ?>
    </select></p>
    <p><input class="submit" type="submit" value="<?php i18n(SB_SHORTNAME.'/ADD_SCHEDULE'); ?>" /></p>
</form>
<?php
unset($_SESSION['add_schedule']);


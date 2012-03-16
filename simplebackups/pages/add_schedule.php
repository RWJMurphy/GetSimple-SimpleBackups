<?php
session_start();
$data = sb_load();
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
        $message = "New schedule added!";
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
<h2>Add schedule</h2>
<form id="add" action="<?php echo sb_link("add_schedule"); ?>" method="POST">
    <p><label for="name">Name:</label><input class="text" name="name" value="<?php if (isset($_SESSION['add_schedule']['name'])) { echo $_SESSION['add_schedule']['name']; } ?>" /></p>
    <p><label for="frequency">Frequency:</label><select class="text" name="frequency">
        <option disabled="disabled">Frequency</option>
        <option <?php if (isset($_SESSION['add_schedule']['frequency']) && $_SESSION['add_schedule']['frequency'] == "hourly") { echo 'selected="selected" '; } ?> value="hourly">hourly</option>
        <option <?php if (isset($_SESSION['add_schedule']['frequency']) && $_SESSION['add_schedule']['frequency'] == "daily") { echo 'selected="selected" '; } ?> value="daily">daily</option>
        <option <?php if (isset($_SESSION['add_schedule']['frequency']) && $_SESSION['add_schedule']['frequency'] == "weekly") { echo 'selected="selected" '; } ?> value="weekly">weekly</option>
        <option <?php if (isset($_SESSION['add_schedule']['frequency']) && $_SESSION['add_schedule']['frequency'] == "monthly") { echo 'selected="selected" '; } ?> value="monthly">monthly</option>
    </select></p>
    <p><label for="limit"># Backups to keep:</label><input class="text" name="limit" value="<?php if (isset($_SESSION['add_schedule']['limit'])) { echo $_SESSION['add_schedule']['limit']; } ?>" /></p>
    <p><label for="source">Source:</label><select class="text" name="source">
        <option disabled="disabled">Source</option>
<?php foreach ($data['sources'] as $id => $source) { ?>
    <option <?php if (isset($_SESSION['add_schedule']['source']) && $_SESSION['add_schedule']['source'] == $id) { echo 'selected="selected" '; } ?> value="<?php echo $id; ?>"><?php echo $source['name']; ?></option>
<?php } ?>
    </select></p>
    <p><label for="destination">Destination:</label><select class="text" name="destination">
        <option disabled="disabled">Destination</option>
<?php foreach ($data['destinations'] as $id => $destination) { ?>
    <option <?php if (isset($_SESSION['add_schedule']['destination']) && $_SESSION['add_schedule']['destination'] == $id) { echo 'selected="selected" '; } ?> value="<?php echo $id; ?>"><?php echo $destination['name']; ?></option>
<?php } ?>
    </select></p>
    <p><input class="submit" type="submit" value="Add" /></p>
</form>
<?php
unset($_SESSION['add_schedule']);


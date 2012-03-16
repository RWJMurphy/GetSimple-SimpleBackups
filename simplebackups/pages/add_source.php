<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $_SESSION['add_source'] = $_POST;
    $result = sb_add_source($_POST['type'], $_POST);
    if (!$result) {
        $redirect = "add_source";
        $message_class = "error";
        $message = sb_get_errors();
    } else {
        unset($_SESSION['add_source']);
        $redirect = "sources";
        $message_class = "success";
        $message = "New source added!";
    }
    $url = sb_link($redirect) . "&$message_class=" . urlencode($message);
    redirect($url);
    exit;
}
?>
<h2>Add source</h2>
<form id="add" action="<?php echo sb_link("add_source"); ?>" method="POST">
    <p><label for="type">Type:</label><select class="text" name="type">
        <option disabled="disabled">Type</option>
        <option <?php if (isset($_SESSION['add_source']['type']) && $_SESSION['add_source']['type'] == "local") { echo 'selected="selected" '; } ?> value="local">Local</option>
    </select></p>
    <p><label for="name">Name:</label><input class="text" name="name" value="<?php if (isset($_SESSION['add_source']['name'])) { echo $_SESSION['add_source']['name']; } ?>" /></p>
<fieldset class="type" id="fs_local"></p>
    <p><label form="local_path">Path:</label><input class="text" name="local_path" value="<?php if (isset($_SESSION['add_source']['local_path'])) { echo $_SESSION['add_source']['local_path']; } else { echo GSBACKUPSPATH . "simplebackups/"; } ?>" /></p>
</fieldset>
    <p><input class="submit" type="submit" value="Add" /></p>
</form>
<?php
unset($_SESSION['add_source']);


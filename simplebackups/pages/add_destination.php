<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $_SESSION['add_destination'] = $_POST;
    $result = sb_add_destination($_POST['type'], $_POST);
    if (!$result) {
        $redirect = "add_destination";
        $message_class = "error";
        $message = sb_get_errors();
    } else {
        unset($_SESSION['add_destination']);
        $redirect = "destinations";
        $message_class = "success";
        $message = "New destination added!";
    }
    $url = sb_link($redirect) . "&$message_class=" . urlencode($message);
    redirect($url);
    exit;
}
queue_script('sb_edit', GSBACK); 
?>
<h2>Add destination</h2>
<form id="add" action="<?php echo sb_link("add_destination"); ?>" method="POST">
    <p><label for="type">Type:</label><select class="text" name="type">
        <option disabled="disabled">Type</option>
        <option <?php if (isset($_SESSION['add_destination']['type']) && $_SESSION['add_destination']['type'] == "local") { echo 'selected="selected" '; } ?> value="local">Local</option>
        <option <?php if (isset($_SESSION['add_destination']['type']) && $_SESSION['add_destination']['type'] == "ftp") { echo 'selected="selected" '; } ?> value="ftp">FTP</option>
        <option <?php if (isset($_SESSION['add_destination']['type']) && $_SESSION['add_destination']['type'] == "s3") { echo 'selected="selected" '; } ?> value="s3">S3</option>
        <option <?php if (isset($_SESSION['add_destination']['type']) && $_SESSION['add_destination']['type'] == "email") { echo 'selected="selected" '; } ?> value="email">Email</option>
    </select></p>
    <p><label for="name">Name:</label><input class="text" name="name" value="<?php if (isset($_SESSION['add_destination']['name'])) { echo $_SESSION['add_destination']['name']; } ?>" /></p>
<fieldset class="type" id="fs_local"></p>
    <p><label form="local_path">Path:</label><input class="text" name="local_path" value="<?php if (isset($_SESSION['add_destination']['local_path'])) { echo $_SESSION['add_destination']['local_path']; } else { echo GSBACKUPSPATH . "simplebackups/"; } ?>" /></p>
</fieldset>
<fieldset class="type" id="fs_ftp">
<p><label for="ftp_host">Host:</label><input class="text" name="ftp_host" value="<?php if (isset($_SESSION['add_destination']['ftp_host'])) { echo $_SESSION['add_destination']['ftp_host']; }?>" /></p>
    <p><label for="ftp_port">Port:</label><input class="text" name="ftp_port" value="<?php if (isset($_SESSION['add_destination']['ftp_port'])) { echo $_SESSION['add_destination']['ftp_port']; } else { echo SB_FTP_PORT_DEFAULT; } ?>" /></p>
    <p><label for="ftp_username">Username:</label><input class="text" name="ftp_username" value="<?php if (isset($_SESSION['add_destination']['ftp_username'])) { echo $_SESSION['add_destination']['ftp_username']; }?>" /></p>
    <p><label for="ftp_password">Password:</label><input class="text" name="ftp_password" value="<?php if (isset($_SESSION['add_destination']['ftp_password'])) { echo $_SESSION['add_destination']['ftp_password']; }?>" /></p>
    <p><label for="ftp_path">Remote Path:</label><input class="text" name="ftp_path" value="<?php if (isset($_SESSION['add_destination']['ftp_path'])) { echo $_SESSION['add_destination']['ftp_path']; } else { echo "/"; }?>" /></p>
</fieldset>
<fieldset class="type" id="fs_s3">
    <p><label for="s3_bucker">Bucket:</label><input class="text" name="s3_bucket" value="<?php if (isset($_SESSION['add_destination']['s3_bucket'])) { echo $_SESSION['add_destination']['s3_bucket']; } ?>" /></p>
    <p><label for="s3_access_key_id">Access Key ID:</label><input class="text" name="s3_access_key_id" value="<?php if (isset($_SESSION['add_destination']['s3_access_key_id'])) { echo $_SESSION['add_destination']['s3_access_key_id']; } ?>" /></p>
    <p><label for="s3_access_key_secret">Access Key Secret:</label><input class="text" name="s3_access_key_secret" value="<?php if (isset($_SESSION['add_destination']['s3_access_key_secret'])) { echo $_SESSION['add_destination']['s3_access_key_secret']; } ?>" /></p>
    <p><label for="s3_path">Remote Path:</label><input class="text" name="s3_path" value="<?php if (isset($_SESSION['add_destination']['s3_path'])) { echo $_SESSION['add_destination']['s3_path']; } ?>" /></p>
</fieldset>
<fieldset class="type" id="fs_email">
    <p><label for="email_address">Address:</label><input class="text" name="email_address" value="<?php if (isset($_SESSION['add_destination']['email_address'])) { echo $_SESSION['add_destination']['email_address']; } ?>" /></p>
    <p><label for="email_subject">Subject:</label><input class="text" name="email_subject" value="<?php if (isset($_SESSION['add_destination']['email_subject'])) { echo $_SESSION['add_destination']['email_subject']; } ?>" /></p>
    </fieldset>
    <p><input class="submit" type="submit" value="Add" /></p>
</form>
<?php
unset($_SESSION['add_destination']);


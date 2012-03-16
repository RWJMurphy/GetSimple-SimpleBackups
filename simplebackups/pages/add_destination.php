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
?>
<style type="text/css">
fieldset.type {
    display: none;
    border: none;
}
</style>
<script type="text/javascript">
function toggle_fieldsets() {
    $("fieldset.type").hide();
    $("#fs_" + $("form#add select[name=type]").val()).show();
}
$(function() {
    toggle_fieldsets();
    $("form#add select[name=type]").change(function(){
        toggle_fieldsets();
    });
});
</script>
<h2>Add destination</h2>
<form id="add" action="<?php echo sb_link("add_destination"); ?>" method="POST">
    <label>Type: <select name="type">
        <option disabled="disabled">Type</option>
        <option <?php if (isset($_SESSION['add_destination']['type']) && $_SESSION['add_destination']['type'] == "local") { echo 'selected="selected" '; } ?> value="local">Local</options>
        <option <?php if (isset($_SESSION['add_destination']['type']) && $_SESSION['add_destination']['type'] == "ftp") { echo 'selected="selected" '; } ?> value="ftp">FTP</options>
        <option <?php if (isset($_SESSION['add_destination']['type']) && $_SESSION['add_destination']['type'] == "s3") { echo 'selected="selected" '; } ?> value="s3">S3</options>
        <option <?php if (isset($_SESSION['add_destination']['type']) && $_SESSION['add_destination']['type'] == "email") { echo 'selected="selected" '; } ?> value="email">Email</options>
    </select></label>
    <label>Name: <input name="name" value="<?php if (isset($_SESSION['add_destination']['name'])) { echo $_SESSION['add_destination']['name']; } ?>" /></label>
<fieldset class="type" id="fs_local">
    <label>Path: <input name="local_path" value="<?php if (isset($_SESSION['add_destination']['local_path'])) { echo $_SESSION['add_destination']['local_path']; } else { echo GSBACKUPSPATH . "simplebackups/"; } ?>" /></label>
</fieldset>
<fieldset class="type" id="fs_ftp">
<label>Host: <input name="ftp_host" value="<?php if (isset($_SESSION['add_destination']['ftp_host'])) { echo $_SESSION['add_destination']['ftp_host']; }?>" /></label>
    <label>Port: <input name="ftp_port" value="<?php if (isset($_SESSION['add_destination']['ftp_port'])) { echo $_SESSION['add_destination']['ftp_port']; } else { echo SB_FTP_PORT_DEFAULT; } ?>" /></label>
    <label>Username: <input name="ftp_username" value="<?php if (isset($_SESSION['add_destination']['ftp_username'])) { echo $_SESSION['add_destination']['ftp_username']; }?>" /></label>
    <label>Password: <input name="ftp_password" value="<?php if (isset($_SESSION['add_destination']['ftp_password'])) { echo $_SESSION['add_destination']['ftp_password']; }?>" /></label>
    <label>Remote Path: <input name="ftp_path" value="<?php if (isset($_SESSION['add_destination']['ftp_path'])) { echo $_SESSION['add_destination']['ftp_path']; } else { echo "/"; }?>" /></label>
</fieldset>
<fieldset class="type" id="fs_s3">
    <label>Bucket: <input name="s3_bucket" value="<?php if (isset($_SESSION['add_destination']['s3_bucket'])) { echo $_SESSION['add_destination']['s3_bucket']; } ?>" /></label>
    <label>Access Key ID: <input name="s3_access_key_id" value="<?php if (isset($_SESSION['add_destination']['s3_access_key_id'])) { echo $_SESSION['add_destination']['s3_access_key_id']; } ?>" /></label>
    <label>Access Key Secret: <input name="s3_access_key_secret" value="<?php if (isset($_SESSION['add_destination']['s3_access_key_secret'])) { echo $_SESSION['add_destination']['s3_access_key_secret']; } ?>" /></label>
    <label>Remote Path: <input name="s3_path" value="<?php if (isset($_SESSION['add_destination']['s3_path'])) { echo $_SESSION['add_destination']['s3_path']; } ?>" /></label>
</fieldset>
<fieldset class="type" id="fs_email">
<label>Address: <input name="email_address" value="<?php if (isset($_SESSION['add_destination']['email_address'])) { echo $_SESSION['add_destination']['email_address']; } ?>" /></label>
<label>Subject: <input name="email_subject" value="<?php if (isset($_SESSION['add_destination']['email_subject'])) { echo $_SESSION['add_destination']['email_subject']; } ?>" /></label>
</fieldset>
    <input type="submit" value="Add" />
</form>
<?php
unset($_SESSION['add_destination']);


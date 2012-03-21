<?php
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
        $message = i18n_r(SB_SHORTNAME.'/SUCCESS_ADD_DESTINATION');
    }
    $url = sb_link($redirect) . "&$message_class=" . urlencode($message);
    redirect($url);
    exit;
}
?>
<h2><?php i18n(SB_SHORTNAME.'/ADD_DESTINATION'); ?></h2>
<form id="add" action="<?php echo sb_link("add_destination"); ?>" method="POST">
    <p><label for="type"><?php i18n(SB_SHORTNAME.'/TYPE'); ?>:</label><select class="text" name="type">
        <option disabled="disabled"><?php i18n(SB_SHORTNAME.'/TYPE'); ?></option>
        <option <?php if (isset($_SESSION['add_destination']['type']) && $_SESSION['add_destination']['type'] == "local") { echo 'selected="selected" '; } ?> value="local"><?php i18n(SB_SHORTNAME.'/LOCAL'); ?></option>
        <option <?php if (isset($_SESSION['add_destination']['type']) && $_SESSION['add_destination']['type'] == "ftp") { echo 'selected="selected" '; } ?> value="ftp"><?php i18n(SB_SHORTNAME.'/FTP'); ?></option>
        <option <?php if (isset($_SESSION['add_destination']['type']) && $_SESSION['add_destination']['type'] == "s3") { echo 'selected="selected" '; } ?> value="s3"><?php i18n(SB_SHORTNAME.'/S3'); ?></option>
        <option <?php if (isset($_SESSION['add_destination']['type']) && $_SESSION['add_destination']['type'] == "email") { echo 'selected="selected" '; } ?> value="email"><?php i18n(SB_SHORTNAME.'/EMAIL'); ?></option>
    </select></p>
    <p><label for="name"><?php i18n(SB_SHORTNAME.'/NAME'); ?>:</label><input class="text" name="name" value="<?php if (isset($_SESSION['add_destination']['name'])) { echo htmlspecialchars($_SESSION['add_destination']['name']); } ?>" /></p>
<fieldset class="type" id="fs_local"></p>
    <p><label form="local_path"><?php i18n(SB_SHORTNAME.'/PATH'); ?>:</label><input class="text" name="local_path" value="<?php if (isset($_SESSION['add_destination']['local_path'])) { echo htmlspecialchars($_SESSION['add_destination']['local_path']); } else { echo GSBACKUPSPATH . "simplebackups/"; } ?>" /></p>
</fieldset>
<fieldset class="type" id="fs_ftp">
<p><label for="ftp_host"><?php i18n(SB_SHORTNAME.'/HOST'); ?>:</label><input class="text" name="ftp_host" value="<?php if (isset($_SESSION['add_destination']['ftp_host'])) { echo htmlspecialchars($_SESSION['add_destination']['ftp_host']); }?>" /></p>
    <p><label for="ftp_port"><?php i18n(SB_SHORTNAME.'/PORT'); ?>:</label><input class="text" name="ftp_port" value="<?php if (isset($_SESSION['add_destination']['ftp_port'])) { echo htmlspecialchars($_SESSION['add_destination']['ftp_port']); } else { echo SB_FTP_PORT_DEFAULT; } ?>" /></p>
    <p><label for="ftp_username"><?php i18n('USERNAME'); ?>:</label><input class="text" name="ftp_username" value="<?php if (isset($_SESSION['add_destination']['ftp_username'])) { echo htmlspecialchars($_SESSION['add_destination']['ftp_username']); }?>" /></p>
    <p><label for="ftp_password"><?php i18n('PASSWORD'); ?>:</label><input type="password" class="text" name="ftp_password" value="<?php if (isset($_SESSION['add_destination']['ftp_password'])) { echo htmlspecialchars($_SESSION['add_destination']['ftp_password']); }?>" /></p>
    <p><label for="ftp_path"><?php i18n(SB_SHORTNAME.'/REMOTE_PATH'); ?>:</label><input class="text" name="ftp_path" value="<?php if (isset($_SESSION['add_destination']['ftp_path'])) { echo htmlspecialchars($_SESSION['add_destination']['ftp_path']); } else { echo "/"; }?>" /></p>
</fieldset>
<fieldset class="type" id="fs_s3">
    <p><label for="s3_bucket"><?php i18n(SB_SHORTNAME.'/BUCKET'); ?>:</label><input class="text" name="s3_bucket" value="<?php if (isset($_SESSION['add_destination']['s3_bucket'])) { echo htmlspecialchars($_SESSION['add_destination']['s3_bucket']); } ?>" /></p>
    <p><label for="s3_access_key_id"><?php i18n(SB_SHORTNAME.'/S3_KEY'); ?>:</label><input class="text" name="s3_access_key_id" value="<?php if (isset($_SESSION['add_destination']['s3_access_key_id'])) { echo htmlspecialchars($_SESSION['add_destination']['s3_access_key_id']); } ?>" /></p>
    <p><label for="s3_access_key_secret"><?php i18n(SB_SHORTNAME.'/S3_SECRET'); ?>:</label><input class="text" name="s3_access_key_secret" value="<?php if (isset($_SESSION['add_destination']['s3_access_key_secret'])) { echo htmlspecialchars($_SESSION['add_destination']['s3_access_key_secret']); } ?>" /></p>
    <p><label for="s3_path"><?php i18n(SB_SHORTNAME.'/REMOTE_PATH'); ?>:</label><input class="text" name="s3_path" value="<?php if (isset($_SESSION['add_destination']['s3_path'])) { echo htmlspecialchars($_SESSION['add_destination']['s3_path']); } ?>" /></p>
</fieldset>
<fieldset class="type" id="fs_email">
    <p><label for="email_address"><?php i18n(SB_SHORTNAME.'/EMAIL_ADDRESS'); ?>:</label><input class="text" name="email_address" value="<?php if (isset($_SESSION['add_destination']['email_address'])) { echo htmlspecialchars($_SESSION['add_destination']['email_address']); } ?>" /></p>
    <p><label for="email_subject"><?php i18n(SB_SHORTNAME.'/EMAIL_SUBJECT'); ?>:</label><input class="text" name="email_subject" value="<?php if (isset($_SESSION['add_destination']['email_subject'])) { echo htmlspecialchars($_SESSION['add_destination']['email_subject']); } ?>" /></p>
    </fieldset>
    <p><input class="submit" type="submit" value="<?php i18n(SB_SHORTNAME.'/ADD_DESTINATION'); ?>" /></p>
</form>
<?php
unset($_SESSION['add_destination']);


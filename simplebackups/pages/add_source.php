<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $message_class = "error";
    $message = "NOPE.avi";
    redirect(sb_link("add_source") . "&$message_class=" . urlencode($message));
    exit;
}
?>
<h2>Add Source</h2>
<form action="<?php echo sb_link("add_source"); ?>" method="POST">
    <label>Name: <input name="name" value="" /></label>
    <label>Path: <?php echo GSROOTPATH; ?><input name="path" value="" /></label>
    <input type="submit" value="Add" />
</form>

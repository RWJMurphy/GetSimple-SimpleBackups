<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $result = sb_add_source($_POST['type'], $_POST);
    if (!$result) {
        $redirect = "add_source";
        $message_class = "error";
        $message = sb_get_errors();
    } else {
        $redirect = "sources";
        $message_class = "success";
        $message = "New source added!";
    }
    redirect(sb_link($redirect) . "&$message_class=" . urlencode($message));
    exit;
}
?>
<h2>Add Source</h2>
<form action="<?php echo sb_link("add_source"); ?>" method="POST">
    <label>Type: <select name="type">
        <option disabled="disabled">Type</option>
        <option value="local">Local</options>
    </select></label>
    <label>Name: <input name="name" value="" /></label>
    <label>Path: <input name="path" value="<?php echo GSROOTPATH; ?>" /></label>
    <input type="submit" value="Add" />
</form>

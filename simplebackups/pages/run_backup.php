<?php
$data = sb_load();
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $source = $data['sources'][$_POST['source']];
    $destination = $data['destinations'][$_POST['destination']];
    $format = $_POST['format'];
    $limit = intval($_POST['limit']);
    $limit = $limit <= 0 ? null : $limit;
    $result = sb_run_backup($source, $destination, $format, $limit);
    if ($result) {
        $message = "Backup successful!";
        $message_class = "success";
    } else {
        $message = "An error occurred performing the backup! I have no idea why.";
        $message_class = "error";
    }
    redirect(sb_link("run_backup") . "&$message_class=" . urlencode($message));
    exit;
}
?>
    <form action="<?php echo sb_link("run_backup"); ?>" method="POST">
Backup
<select name="source">
    <option value="" disabled="disabled">Source</option>
<?php foreach($data['sources'] as $key => $source): ?>
    <option value="<?php echo $key; ?>" ><?php echo $source['name']; ?></option>
<?php endforeach; ?>
</select>
to
<select name="destination">
    <option value="" disabled="disabled">Destination</option>
<?php foreach($data['destinations'] as $key => $destination): ?>
    <option value="<?php echo $key; ?>" ><?php echo $destination['name']; ?></option>
<?php endforeach; ?>
</select>
as
<select name="format">
    <option value="" disabled="disabled">Format</option>
<?php foreach($data['archive_formats'] as $format): ?>
    <option value="<?php echo $format; ?>" ><?php echo $format; ?></option>
<?php endforeach; ?>
</select>
, keeping <input name="limit" size="2"/> backups.

<input type="submit" value="Go!" />
</form>

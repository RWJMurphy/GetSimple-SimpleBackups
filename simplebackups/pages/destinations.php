<?php
$data = sb_load();
?>
<h2><?php i18n(SB_SHORTNAME.'/DESTINATIONS'); ?></h2>
<table>
    <tbody>
        <tr>
            <th><?php i18n(SB_SHORTNAME.'/NAME'); ?></th>
            <th><?php i18n(SB_SHORTNAME.'/TYPE'); ?></th>
            <th><?php i18n(SB_SHORTNAME.'/DESCRIPTION'); ?></th>
            <th></th>
        </tr>
<?php
foreach ($data['destinations'] as $key => $destination) {
    $name = $destination['name'];
    $type = $destination['type'];
    $description = "";
    switch($type) {
    case "local":
        $description = $destination['path'];
        break;
    case "ftp":
        $description = "ftp://";
        if ($destination['username']) {
            $description .= $destination['username'] . "@";
        }
        $description .= $destination['host'];
        if ($destination['port'] != SB_FTP_PORT_DEFAULT) {
            $description .= ":" . $destination['port'];
        }
        $description .= $destination['path'];
        break;
    case "email":
        $description = "mailto:" . $destination['address'];
        break;
    case "s3":
        $description = "s3://" . $destination['bucket'] . $destination['path'];
        break;
    default:
        break;
    }
?>
        <tr>
            <td class="posttitle"><a title="<?php i18n(SB_SHORTNAME.'/EDIT_DESTINATION'); ?>: <?php echo $name; ?>" href="<?php echo sb_link("edit_destination", $key); ?>"><?php echo $name; ?></a></td>
            <td><?php echo $type; ?></td>
            <td><?php echo $description; ?></td>
            <td class="delete"><a class="delconfirm" href="<?php echo sb_link("delete_destination", $key); ?>" title="<?php i18n(SB_SHORTNAME.'/DELETE_DESTINATION'); ?>: <?php echo $name; ?>">X</a></td>
            <td class="indexColumn" style="display: none;"><?php echo "$name $type"; ?></td>
        </tr>
<?php } ?>
    </tbody>
</table>

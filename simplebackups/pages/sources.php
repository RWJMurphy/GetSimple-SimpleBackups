<?php
$data = sb_load();
?>
<table>
    <tbody>
        <tr>
            <th>Name</th>
            <th>Type</th>
            <th></th>
        </tr>
<?php
foreach ($data['sources'] as $key => $source):
    $name = $source['name'];
    $type = $source['type'];
?>
        <tr>
            <td class="posttitle"><a title="Edit source: <?php echo $name; ?>" href="<?php echo sb_link("edit_source", $key); ?>"><?php echo $name; ?></a></td>
            <td><?php echo $type; ?></td>
            <td class="delete"><a class="delconfirm" href="<?php echo sb_link("delete_source", $key); ?>" title="Delete source: <?php echo $name; ?>">X</a></td>
            <td class="indexColumn" style="display: none;"><?php echo "$name $type"; ?></td>
        </tr>
<?php
endforeach;
?>
    </tbody>
</table>

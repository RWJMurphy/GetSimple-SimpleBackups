<?php
function sb_render_header() {
    $sb_config = sb_config();
    $action = sb_current_action();
    if (isset($sb_config['submenu_actions'][$action])) {
        $submenu = $sb_config['submenu_actions'][$action];
    } else {
        $submenu = array();
        foreach ($sb_config['submenu_actions'] as $key => $submenu_items) {
            if (array_key_exists($action, $submenu_items)) {
                $submenu = $submenu_items;
                break;
            }
        }
    }
?>
    <h3 class="floated"><?php echo SB_NAME; ?></h3>
    <div class="edit-nav clearfix">
<?php foreach($submenu as $action => $text) { ?>
    <a <?php if (sb_is_current_action($action)) { echo 'class="current"'; } ?> href="<?php echo sb_link($action); ?>"><?php echo $text; ?></a>
<?php } ?>
    </div>
<?php
}

function sb_render_page($page) {
    $filename = SB_PAGESPATH . $page . ".php";
    if (file_exists($filename)) {
        require $filename;
    } else {
        sb_render_not_implemented($page);
    }
}

function sb_render_not_implemented($page) {
    echo '<h4>'.sprintf(i18n_r(SB_SHORTNAME.'/NOT_IMPLEMENTED'), $page).'</h4>';
}

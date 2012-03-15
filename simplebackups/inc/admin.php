<?php
function sb_render_header() {
    $menu = array(
        "schedules" => "Schedules",
        "destinations" => "Destinations",
        "sources" => "Sources",
        "run_backup" => "Run Backup Now"
    );
?>
    <h3 class="floated"><?php echo SB_NAME; ?></h3>
    <div class="edit-nav clearfix">
<?php foreach($menu as $action => $text) { ?>
    <a <?php if (sb_is_current_action($action)) { echo 'class="current"'; } ?> href="<?php echo sb_link($action); ?>"><?php echo $text; ?></a>
<?php } ?>
    </div>
<?php
}

function sb_render_page($page) {
    $filename = SB_PAGESPATH . $page . ".php";
    print "<!-- $filename -->";
    if (file_exists($filename)) {
        require $filename;
    } else {
        sb_render_not_implemented();
    }
}

function sb_render_not_implemented() {
    echo '<h4>Not yet implemented.</h4>';
}

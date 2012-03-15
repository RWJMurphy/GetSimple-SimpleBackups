<?php
$thisfile=basename(__FILE__, ".php");
require_once $thisfile . "/inc/include.php";

register_plugin(
    SB_SHORTNAME,
    SB_NAME,
    SB_VERSION,
    SB_AUTHOR,
    SB_URL,
    SB_DESCRIPTION,
	'backups',
	'sb_admin'
);

add_action('backups-sidebar', 'createSideMenu', array(SB_SHORTNAME, SB_NAME));

#add_action('index-posttemplate','sb_cron');

function sb_admin() {
    $sb_config = sb_config();
    sb_render_header();
    $action = isset($_GET['action']) ? $_GET['action'] : $sb_config['default_action'];
    sb_render_page($action);
}

function sb_cron() {
    return;
}

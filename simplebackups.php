<?php
$thisfile=basename(__FILE__, ".php");
i18n_merge($thisfile) || i18n_merge($thisfile, 'en_US');
require_once $thisfile . "/inc/include.php";
$sb_config = sb_config();

register_plugin(
    SB_SHORTNAME,
    SB_NAME,
    SB_VERSION,
    SB_AUTHOR,
    SB_URL,
    SB_DESCRIPTION,
	SB_TABNAME,
	SB_ACTION_MAIN
);

add_action('nav-tab', 'createNavTab', array(SB_TABNAME, SB_SHORTNAME, SB_NAME, 'run_backup'));
foreach ($sb_config['menu_actions'] as $action => $description) {
    add_action(SB_TABNAME . '-sidebar', 'createSideMenu', array(SB_SHORTNAME, $description, $action));
}
add_action('index-posttemplate', 'sb_action_cron');

register_script('sb_edit', SB_JSURL . 'sb_edit.js', SB_VERSION, False);
register_style('sb_main', SB_CSSURL . 'sb_main.css', SB_VERSION, 'screen');

queue_script('sb_edit', GSBACK);
queue_style('sb_main', GSBACK);


function sb_action_admin() {
    session_start();

    $sb_config = sb_config();
    sb_render_header();
    $selected_action = sb_current_action();
    sb_render_page($selected_action);
}

function sb_action_cron() {
    sb_cron();
}

<?php
$sb_config = array(
    "actions" => array(
        "run_backup",
        "sources", "add_source", "edit_source", "delete_source",
        "destinations", "add_destination", "edit_destination", "delete_destination",
        "schedules", "add_schedule", "edit_schedule", "delete_schedule",
        "logs", "delete_log", "delete_all_logs"
    ),
    "menu_actions" => array(
        "run_backup" => "Run Backup Now",
        "sources" => "Sources",
        "destinations" => "Destinations",
        "schedules" => "Schedules",
        "logs" => "Logs"
    ),
    "submenu_actions" => array(
        "run_backup" => array(),
        "sources" => array(
            "sources" => i18n_r(SB_SHORTNAME.'/LIST_SOURCES'),
            "add_source" => i18n_r(SB_SHORTNAME.'/NEW_SOURCE')
        ),
        "destinations" => array(
            "destinations" => i18n_r(SB_SHORTNAME.'/LIST_DESTINATIONS'),
            "add_destination" => i18n_r(SB_SHORTNAME.'/NEW_DESTINATION')
        ),
        "schedules" => array(
            "schedules" => i18n_r(SB_SHORTNAME.'/LIST_SCHEDULES'),
            "add_schedule" => i18n_r(SB_SHORTNAME.'/NEW_SCHEDULE')
        ),
        "logs" => array(
            "delete_all_logs" => i18n_r(SB_SHORTNAME.'/DELETE_ALL_LOGS')
        )
    ),
    "default_action" => "run_backup",
    "xml" => array(
        "sources" => SB_XMLPATH . "/sources.xml",
        "destinations" => SB_XMLPATH . "/destinations.xml",
        "schedules" => SB_XMLPATH . "/schedules.xml",
        "archive_formats" => SB_XMLPATH . "/archive_formats.xml",
        "last_run" => SB_XMLPATH . "/last_run.xml",
        "logs" => SB_XMLPATH . "/logs.xml"
    ),
    "default_settings" => array(
        "sources" => array(
            array(
                "name" => i18n_r(SB_SHORTNAME.'/ALL_FILES'),
                "type" => "local",
                "path" => GSROOTPATH
            ),
            array(
                "name" => i18n_r(SB_SHORTNAME.'/DATA_FILES'),
                "type" => "local",
                "path" => GSDATAPATH
            )
        ),
        "destinations" => array(
            array(
                "name" => i18n_r(SB_SHORTNAME.'/LOCAL_BACKUPS'),
                "type" => "local",
                "path" => SB_BACKUPPATH
            )
        ),
        "schedules" => array(),
        "archive_formats" => array(
            ".tar.gz",
            ".zip"
        ),
        "last_run" => array(
            "source" => 0,
            "destination" => 0,
            "format" => ".tar.gz",
            "limit" => 10
        )
    ),
    "binaries" => array(
        "tar" => "tar"
    ),
    "schedule_frequencies" => array(
        i18n_r(SB_SHORTNAME.'/SCHEDULE_HOURLY'),
        i18n_r(SB_SHORTNAME.'/SCHEDULE_DAILY'),
        i18n_r(SB_SHORTNAME.'/SCHEDULE_WEEKLY'),
        i18n_r(SB_SHORTNAME.'/SCHEDULE_MONTHLY')
    )
);

function sb_config() {
    global $sb_config;
    return $sb_config;
}

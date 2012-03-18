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
            "sources" => "List sources",
            "add_source" => "New source"
        ),
        "destinations" => array(
            "destinations" => "List destinations",
            "add_destination" => "New destination"
        ),
        "schedules" => array(
            "schedules" => "List schedules",
            "add_schedule" => "New schedule"
        ),
        "logs" => array(
            "delete_all_logs" => "Delete all logs"
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
                "name" => "All files",
                "type" => "local",
                "path" => GSROOTPATH
            ),
            array(
                "name" => "Data files",
                "type" => "local",
                "path" => GSDATAPATH
            )
        ),
        "destinations" => array(
            array(
                "name" => "Local backups folder",
                "type" => "local",
                "path" => GSBACKUPSPATH . "simplebackups/"
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
        "hourly",
        "daily",
        "weekly",
        "monthly"
    )
);

function sb_config() {
    global $sb_config;
    return $sb_config;
}

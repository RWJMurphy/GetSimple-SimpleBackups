<?php
$sb_config = array(
    "menu_actions" => array(
        "run_backup" => "Run Backup Now",
        "sources" => "Sources",
        "destinations" => "Destinations",
        "schedules" => "Schedules"
    ),
    "submenu_actions" => array(
        "run_backup" => array(),
        "sources" => array(),
        "destinations" => array(),
        "schedules" => array()
    ),
    "default_action" => "run_backup",
    "xml" => array(
        "sources" => GSDATAOTHERPATH . "scheduled_backups/sources.xml",
        "destinations" => GSDATAOTHERPATH . "scheduled_backups/destinations.xml",
        "schedules" => GSDATAOTHERPATH . "scheduled_backups/schedules.xml",
        "archive_formats" => GSDATAOTHERPATH . "scheduled_backups/archive_formats.xml",
        "last_run" => GSDATAOTHERPATH . "scheduled_backups/last_run.xml"
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
    )
);

function sb_config() {
    global $sb_config;
    return $sb_config;
}

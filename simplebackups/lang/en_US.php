<?php
$i18n = array(
/* Plugin Data */
    'PLUGIN_NAME' => "Simple Backups",
    'PLUGIN_DESCRIPTION' => "Automatic, schedulable remote and local backups.",

/* Error / status messages */
    'UNSUPPORTED_ARCHIVE' => "Unsupported archive format '%s'.",
    'UNSUPPORTED_DESTINATION' => "Unsupported destination type '%s'.",

    'ERROR_EMAIL' => "There was an error emailing '%s' to '%s'.",
    'ERROR_MOVEFILE' => "There was an error moving the archive to '%s'.",
    'ERROR_SCHEDULE' => "Error running scheduled backup '%s': %s",
    'ERROR_TARGZ' => "There was an error creating the .tar.gz archive.",

    'ERROR_VALID_NAME' => "You must supply a name.",
    'ERROR_VALID_TYPE' => "You must select a valid type.",

    'ERROR_VALID_LOCAL_PATH' => "You must supply a local path.",
    'ERROR_VALID_FTP_HOSTNAME' => "You must supply a hostname for the FTP server.",
    'ERROR_VALID_FTP_POST' => "Invalid FTP port.",
    'ERROR_VALID_S3_BUCKET' => "You must supply a bucket name.",
    'ERROR_VALID_S3_KEY' => "You must supply an Access Key Id.",
    'ERROR_VALID_S3_SECRET' => "You must provide a Secret Access Key.",
    'ERROR_VALID_EMAIL_ADDRESS' => "You must supply an email address.",
    'ERROR_VALID_EMAIL_SUBJECT' => "You must supply a subject line.",

    'ERROR_VALID_FREQUENCY' => "You must choose a valid frequency.",
    'ERROR_VALID_LIMIT' => "Backup count must be greater than 0, or blank.",
    'ERROR_VALID_SOURCE' => "You must choose a valid source.",
    'ERROR_VALID_DESTINATION' => "You must choose a valid destination.",
    'ERROR_VALID_ARCHIVE_FORMAT' => "You must choose a valid archive format.",

    'ERROR_SAVING_SOURCE' => "There was an error saving source data.",
    'ERROR_DELETING_SOURCE' => "There was an error deleting the source.",
    'ERROR_SAVING_SCHEDULE' => "There was an error saving schedule data.",
    'ERROR_UPDATING_SCHEDULE' => "Error updating schedule '%s'",
    'ERROR_DELETING_SCHEDULE' => "There was an error deleting the schedule.",
    'ERROR_SAVING_DESTINATION' => "There was an error saving destination data.",
    'ERROR_DELETING_DESTINATION' => "There was an error deleting the destination.",
    'ERROR_DELETING_LOG' => "There was an error deleting the log.",
    'ERROR_DELETING_LOGS' => "There was an error deleting logs.",

    'SUCCESS_EMAIL' => "Emailed '%s' to '%s'.",
    'SUCCESS_SCHEDULE' => "Scheduled backup '%s' run successfully.",

    'SUCCESS_ADD_DESTINATION' => "New destination added!",
    'SUCCESS_ADD_SCHEDULE' => "New schedule added!",
    'SUCCESS_ADD_SOURCE' => "New source added!",

    'SUCCESS_DELETE_ALL_LOGS' => "All logs deleted!",
    'SUCCESS_DELETE_LOG' => "Log deleted!",
    'SUCCESS_DELETE_SCHEDULE' => "Schedule deleted!",
    'SUCCESS_DELETE_SOURCE' => "Source deleted!",
    'SUCCESS_DELETE_DESTINATION' => "Destination deleted!",

    'RUNNING_SCHEDULED' => "Running scheduled backup '%s'.",

    'NOT_IMPLEMENTED' => "%s support not implemented.",

/* Menu Items */
    'LIST_SOURCES' => "List Sources",
    'NEW_SOURCE' => "New Source",
    'LIST_DESTINATIONS' => "List Destinations",
    'NEW_DESTINATION' => "New Destination",
    'LIST_SCHEDULES' => "List Schedules",
    'NEW_SCHEDULE' => "New Schedule",
    'DELETE_ALL_LOGS' => "Delete all logs",

/* Default Source & Destinations */
    'ALL_FILES' => "All files",
    'DATA_FILES' => "Data files",
    'LOCAL_BACKUPS' => "Local backups folder",

/* Schedule types / names */
    'SCHEDULE_HOURLY' => "hourly",
    'SCHEDULE_DAILY' => "daily",
    'SCHEDULE_WEEKLY' => "weekly",
    'SCHEDULE_MONTHLY' => "monthly",

/* Email */
    'EMAIL_BODY' => "Latest backup attached.",

/* HTML UI values */
    'NAME' => "Name",
    'TYPE' => "Type",
    'DESCRIPTION' => "Description",
    'LOCAL' => "Local",
    'FTP' => "FTP",
    'S3' => "S3",
    'EMAIL' => "Email",
    'PATH' => "Path",
    'HOST' => "Host",
    'PORT' => "Port",
    'USERNAME' => "Username",
    'PASSWORD' => "Password",
    'REMOTE_PATH' => "Remote Path",
    'BUCKET' => "Bucket",
    'S3_KEY' => "Access Key Id",
    'S3_SECRET' => "Secret Access Key",
    'EMAIL_ADDRESS' => "Email Address",
    'EMAIL_SUBJECT' => "Subject",
    'ADD_DESTINATION' => "Add Destination",
    'ADD_SCHEDULE' => "Add Schedule",
    'ADD_SOURCE' => "Add Source",
    'FREQUENCY' => "Frequency",
    'BACKUP_LIMIT' => "# Backups to keep",
    'SOURCE' => "Source",
    'DESTINATION' => "Destination",
    'DESTINATIONS' => "Destinations",
    'ARCHIVE_FORMAT' => "Archive Format",
    'EDIT_DESTINATION' => "Edit destination",
    'DELETE_DESTINATION' => "Delete destination",
    'LOGS' => "Logs",
    'TIMESTAMP' => "Timestamp",
    'LEVEL' => "Level",
    'MESSAGE' => "Message",
    'LOG_DEBUG' => "debug",
    'LOG_INFO' => "info",
    'LOG_WARNING' => "warning",
    'LOG_ERROR' => "error",
    'LOG_CRITICAL' => "critical",
    'LOG_UNKNOWN' => "unkown",
    'DELETE_LOG' => "Delete log",
    'RUN_BACKUP_NOW' => "Run Backup Now",

    'BACKUP' => "Backup",
    "BACKUPS" => "backups",
    'TO' => "to",
    'AS' => "as",
    'KEEPING' => "keeping",
    'GO!' => "Go!",

    'SCHEDULES' => "Schedules",
    'LIMIT' => "Limit",
    'LAST_RUN' => "Last Run",
    'DELETE_SCHEDULE' => "Delete schedule",
    'EDIT_SCHEDULE' => "Edit schedule",

    'SOURCES' => "Sources",
    'EDIT_SOURCE' => "Edit source",
    'DELETE_SOURCE' => "Delete source",

    /* FTP Errors */
    'FTP_CONNECT_FAILED' => "Connecting to FTP server '%s' failed.",
    'FTP_LOGIN_FAILED' => "Logging in to FTP server '%s' failed.",
    'FTP_CHDIR_FAILED' => "Changing directory on FTP server '%s' failed.",

    /* S3 Errors */
    'S3_CONNECT_FAILED' => "Connecting to S3 bucket '%s' failed - %s",
);

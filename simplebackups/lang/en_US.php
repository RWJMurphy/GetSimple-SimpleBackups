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
    'TYPE' => "Type",
    'LOCAL' => "Local",
    'FTP' => "FTP",
    'S3' => "S3",
    'EMAIL' => "Email",
    'NAME' => "Name",
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
    'FREQUENCY' => "Frequency",
    'BACKUP_LIMIT' => "# Backups to keep",
    'SOURCE' => "Source",
    'DESTINATION' => "Destination",
    'ARCHIVE_FORMAT' => "Archive Format",
);

<?php
define('SB_SHORTNAME', 'simplebackups');
define('SB_NAME', i18n_r(SB_SHORTNAME.'/PLUGIN_NAME'));
define('SB_VERSION', '1.0.1');
define('SB_AUTHOR', 'Reed Murphy');
define('SB_URL', 'http://www.reedmurphy.net/');
define('SB_DESCRIPTION', i18n_r(SB_SHORTNAME.'/PLUGIN_DESCRIPTION'));

define('SB_TABNAME', SB_SHORTNAME);
define('SB_ACTION_MAIN', 'sb_action_admin');

define('SB_FTP_PORT_DEFAULT', 21);

define('SB_ROOTPATH', GSPLUGINPATH . SB_SHORTNAME . "/");
define('SB_PAGESPATH', SB_ROOTPATH . "pages/");
define('SB_TEMPPATH', GSDATAOTHERPATH . SB_SHORTNAME . "/temp/");
define('SB_XMLPATH', GSDATAOTHERPATH . SB_SHORTNAME . "/xml/");
define('SB_BACKUPPATH', GSBACKUPSPATH . "simplebackups/");

define('SB_PLUGINURL', $SITEURL.'plugins/'.SB_SHORTNAME.'/');
define('SB_CSSURL', SB_PLUGINURL.'css/');
define('SB_JSURL', SB_PLUGINURL.'js/');

define('SB_LOG_TIMEFORMAT', "Y-m-d H:i:s");
define('SB_LOG_DEBUG', 0);
define('SB_LOG_INFO', 1);
define('SB_LOG_WARNING', 2);
define('SB_LOG_ERROR', 3);
define('SB_LOG_CRITICAL', 4);

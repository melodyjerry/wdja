<?php
//****************************************************
// WDJA CMS Power by wdja.cn
// Email: admin@wdja.cn
// Web: http://www.wdja.cn/
//****************************************************
ob_start();
session_start();
define('ADMIN_FOLDER', 'admin');
define('APP_NAME', 'wdja_');
define('CACHE_DIR', '_CACHE');
define('CHARSET', 'utf-8');
define('COOKIES_PATH', '/');
define('CRLF', chr(13) . chr(10));
define('GMT_PLUS', 8);
define('WDJA_CINFO', '<!--WDJA_CINFO-->');
define('NAV_SP_STR', ' &raquo; ');
define('SP_STR', '_');
define('SYS_NAME', 'WDJA');
define('USER_FOLDER', 'passport');
define('XML_SFX', '.wdja');
if(!defined('E_DEPRECATED')) error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
else error_reporting(E_ALL ^ E_NOTICE ^ E_DEPRECATED ^ E_WARNING);
header('Content-Type: text/html; charset=' . CHARSET);
$starttime = microtime(1);
$db_host = '127.0.0.1';
$db_username = 'root';
$db_password = 'root';
$db_database = 'wdja';
$default_language = 'chinese';
$default_template = 'tpl_default';
$default_skin = 'default';
$default_head = 'default_head';
$default_foot = 'default_foot';
//****************************************************
// WDJA CMS Power by wdja.cn
// Email: admin@wdja.cn
// Web: http://www.wdja.cn/
//****************************************************
?>

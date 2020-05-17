<?php
$root_path	= preg_match('/\/$/',$_SERVER['DOCUMENT_ROOT']) ? $_SERVER['DOCUMENT_ROOT'] : $_SERVER['DOCUMENT_ROOT'].'/';
define ("root_path", $root_path);

date_default_timezone_set('Europe/Moscow'); //or change to whatever timezone you want
ini_set("memory_limit", "32M");
ini_set('short_open_tag', 'On');
setlocale (LC_ALL, "ru_RU.UTF-8");
setlocale (LC_NUMERIC, "C");
set_time_limit(10);


// IfModified Since check, true -on (recommended); false -off (debug);
if($_SERVER['REMOTE_ADDR'] == 'enter your ip for debugging'){ 
	define ("metrics", true);
	define ("cachePageAndDB", false);
	define ("ifmsCheck", false);
	$display_error = 'yes';
} else {
	define ("metrics", true);
	define ("cachePageAndDB", true);
	define ("ifmsCheck", true);
	$display_error = 'no';
}

const expires			= 3600;
const siteUrl			= "https://admin.seo-marketing.spb.ru";
const pages_dir			= 'templates/';
const email				= 'dcs-spb@ya.ru';
const pepper			= 'E)H@McQfTjWnZr4t7w!z%C*F-JaNdRgU'; // Pepper for password sha256 hash functions, warning do not change, will loast all passwords and confirm emails, false - off


$request_url= parse_url($_SERVER['REQUEST_URI']);
$urlMd5= md5( $_SERVER['SERVER_NAME'].$request_url['path'] ); 

#######################################################################
const db_host		= "localhost";
const db_login		= "admin_console";
const db_pass		= "2V0o8A6s";
const db_dbname		= "admin_console";

#######################################################################

switch($display_error){
	case 'yes': error_reporting(2047); break;
	case 'no': error_reporting(0);  break;
}

#######################################################################

$mod= $_GET['mod'] ?? 'index';
$page= $_GET['page'] ?? false;
$submod= $_GET['submod'] ?? false;
$subpage= $_GET['subpage'] ?? false;
$templates= [];
#######################################################################



?>

<?
error_reporting( E_ALL );
ini_set('display_errors', true);
header("Content-type: text/html; charset=utf-8");

include "tools.php";
print MadFront::getInstance();

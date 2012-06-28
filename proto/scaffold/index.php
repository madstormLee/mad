<?
error_reporting( E_ALL );
ini_set('display_errors', true);
include $_SERVER['DOCUMENT_ROOT'] . "/mad/tools.php";
header("Content-type: text/html; charset=utf-8");

$front = MadFront::getInstance();
print $front;

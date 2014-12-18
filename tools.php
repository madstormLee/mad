<?
date_default_timezone_set('Asia/Seoul');

// constants
define( 'BR', "<br />\n" );
define( 'DS', '/' );

define( 'ROOT', realpath( $_SERVER['DOCUMENT_ROOT'] . DS ) . DS );
define( 'MAD', dirname(__file__) . DS );
define( 'MADTOOLS', MAD . 'tools' . DS );
define( 'PROJECT_ROOT', realpath( dirName( ROOT . $_SERVER['SCRIPT_NAME'] ) ) . '/' );

/***************** includes *****************/
require_once 'functions.php';
require_once MADTOOLS . 'MadAutoload.php';
MadAutoload::getInstance()->add( MADTOOLS );

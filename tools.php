<?
date_default_timezone_set('Asia/Seoul');

// constants
define( 'BR', "\n<br />\n" );
define( 'DS', '/' );

define( 'ROOT', realpath( $_SERVER['DOCUMENT_ROOT'] . DS ) . DS );
define( 'MAD', dirname(__file__) . DS );
define( 'MADTOOLS', MAD . 'tools' . DS );
define( 'PROJECT_ROOT', realpath( dirName( ROOT . $_SERVER['SCRIPT_NAME'] ) ) . '/' );

define('IS_GET', empty( $_POST ) );
define('IS_POST', ! IS_GET );
define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');

define('IS_INTERNAL', ( isset( $_SERVER['REMOTE_ADDR'] ) && $_SERVER['REMOTE_ADDR'] === '127.0.0.1' ) );

/***************** includes *****************/
require_once 'tools/MadAutoload.php';
MadAutoload::getInstance()->add( MADTOOLS );

<?
date_default_timezone_set('Asia/Seoul');

define( 'BR', "\n<br />\n" );
define( 'DS', '/' );

define( 'ROOT', realpath( $_SERVER['DOCUMENT_ROOT'] . DS ) . DS );
define( 'MAD', dirname(__file__) . DS );
define( 'MADTOOLS', MAD . 'tools' . DS );

define('MAD_AUTO_INSTALL', true);
define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');

/***************** includes *****************/
require_once MAD . 'functions.php';
require_once MADTOOLS . 'MadAutoload.php';

MadAutoload::getInstance()
->addDir( './' )
->addDir( MADTOOLS )
->addDir( 'models/' );

function __autoload( $className ) {
	foreach( MadAutoload::getInstance() as $dirName ) {
		$fileName = $dirName . $className . '.php';
		if ( is_file( $fileName ) ) {
			require_once( $fileName );
			return true;
		}
	}
	return false;
}

/******************* session ***********************/
if ( '' == session_id() ) {
	session_start();
}

<?
date_default_timezone_set('Asia/Seoul');

// constants
define( 'BR', "<br />\n" );
define( 'DS', '/' );

define( 'ROOT', realpath( $_SERVER['DOCUMENT_ROOT'] . DS ) . DS );
define( 'MAD', dirname(__file__) . DS );
define( 'MADTOOLS', MAD . 'tools' . DS );
define( 'PROJECT_ROOT', realpath( dirName( ROOT . $_SERVER['SCRIPT_NAME'] ) ) . '/' );

// defaulting
if (get_magic_quotes_gpc()) {
	$process = array(&$_GET, &$_POST, &$_COOKIE, &$_REQUEST);
	while (list($key, $val) = each($process)) {
		foreach ($val as $k => $v) {
			unset($process[$key][$k]);
			if (is_array($v)) {
				$process[$key][stripslashes($k)] = $v;
				$process[] = &$process[$key][stripslashes($k)];
			} else {
				$process[$key][stripslashes($k)] = stripslashes($v);
			}
		}
	}
	unset($process);
}

/***************** includes *****************/
require_once 'tools/functions.php';
require_once MADTOOLS . 'MadAutoload.php';
MadAutoload::getInstance()->add( MADTOOLS );

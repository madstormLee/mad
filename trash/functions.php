<?
function ckKey( $key, &$array, $default=false ) {
	return isset( $array[$key] ) ? $array[$key] : $default;
}
function ckValue( $value, $arr ) {
	if ( in_array( $value, $arr ) ) {
		return $value;
	}
	return false;
}
function ckGet( $key, $default=false ) {
	return ckKey( $key, $_GET, $default );
}
function ckPost( $key, $default=false ) {
	return ckKey( $key, $_POST, $default );
}
function ckSess( $key, $expected = '' ) {
	$rv = false;
	if ( isset($_SESSION[$key]) ) {
		$rv = $_SESSION[$key];
		if ( ! empty($expected) && $rv != $expected ) {
			$rv = false;
		}
	}
	return $rv;
}
function kNatSort( &$array ) {
	$rv = array();
	$keys = array_keys( $array );
	natsort( $keys );
	foreach( $keys as $key ) {
		$rv[$key] = $array[$key];
	}
	$array = $rv;
	return $array;
}

/******************** debug functions ******************/
function (new MadDebug)->printRuntime() {
	print ( microtime( true ) - $GLOBALS['scriptTime'] ) . 'seconds';
	print '<br />';
}

function isArray( &$array ) {
	return (bool)(
		$array instanceof ArrayAccess ||
		$array instanceof Traversable ||
		is_array($array)
		);
}
function equals( $a , $b ) {
	return ( isset($a) && $a == $b ) ? true : false;
}
function test( $testName ) {
	include "tests/$testName.php";
	$test = new $testName;
	foreach( $test as $action ) {
		$test->$action();
	}
}
function printPre( $data ) {
	print "<pre style='font-size: 12px;'>";
	print $data;
	print '</pre>';
}
if ( ! function_exists( '(new MadDebug)->printR' ) ) {
	function (new MadDebug)->printR( $data, $option=false ) {
		$rv = '<pre style="font-size: 12px">';
		$rv .= print_r( $data, true );
		$rv .='</pre>';
		if ( $option == true ) {
			return $rv;
		}
		print $rv;
	}
}
if ( ! function_exists( 'varDump' ) ) {
	function varDump( $data ) {
		print '<pre style="font-size: 12px">';
		var_dump( $data );
		print '</pre>';
	}
}
function blank( $value ) {
	$value = trim($value);
	if ( empty($value) ) return true;
	else return false;
}
function sqlin($string){
	if( is_array($string) ){
		$rv = array();
		foreach($string as $key => $value){
			$rv[$key] = sqlin($value);
		}
	} else {
		$rv = '';
		$rv=trim($string);
		if(!get_magic_quotes_gpc()) $rv=addSlashes($rv);
	}
	return $rv;
}
function sqlout($string, $flag = false){
	if( is_array($string) ){
		$rv = array();
		foreach($string as $key => $value){
			$rv[$key]=sqlout($value, $flag);
		}
	} else {
		$rv = '';
		$rv = $string;
		$rv = stripslashes($rv);
		if ( $flag ) {
			$rv = htmlspecialchars($rv);
		}
	}
	return $rv;
}
function flashin($file_name,$width='',$height=''){
	$file_name = $file_name . '.swf';
	$rv = "<script>Flash.print('$file_name',$width, $height)</script>";
	return $rv;
}
if ( ! function_exists( 'alert' ) ) {
	function alert($msg, $address='', $flag=''){
		$msg = str_replace( "'", '"', $msg );
		echo "<script>alert('$msg');</script>";
		if ( !empty($address) ) {
			move($address,$flag);
		}
	}
}
if ( ! function_exists( 'move' ) ) {
	function move($page, $flag='href'){
		$referer = ( isset($_SERVER['HTTP_REFERER']) ) ? $_SERVER['HTTP_REFERER']:'';
		$moveWay = 'location.href=';

		if ( $flag == 'replace' && $page == 'back' && !empty($referer) ) {
			$page = $referer;
		}
		if ( $flag == 'replace' ) {
			$moveWay = 'location.replace';
		} else if ( $page == 'back' ) {
			$moveWay = 'history.back';
			$page = '';
		}
		print  "<script>$moveWay('$page');</script>";
		die;
	}
}
function replace($page){
	move($page, 'replace');
}
function closeWindow( $url = '' ) {
	print "<script>window.close();</script>";
	replace( $url );
	die;
}
function moveOpener( $href ) {
	print "<script>opener.window.location.href='$href';</script>";
}
function is_table($table_name){
	$query = "show tables like '%$table_name%'";
	$q = new Q($query);
	return $q->rows();
}

/******************************** file ********************************/
function formatBytes($bytes, $precision = 2) { 
	$units = array('B', 'KB', 'MB', 'GB', 'TB'); 

	$bytes = max($bytes, 0); 
	$pow = floor(($bytes ? log($bytes) : 0) / log(1024)); 
	$pow = min($pow, count($units) - 1); 

	// Uncomment one of the following alternatives
	$bytes /= pow(1024, $pow);
	// $bytes /= (1 << (10 * $pow)); 

	return round($bytes, $precision) . ' ' . $units[$pow]; 
} 
// from : jyotsnachannagiri@gmail.com 
function dircopy($src_dir, $dst_dir,$UploadDate=false, $verbose = false, $use_cached_dir_trees = false) {
	static $cached_src_dir;
	static $src_tree;
	static $dst_tree;
	$num = 0;

	if(($slash = substr($src_dir, -1)) == "\\" || $slash == "/") $src_dir = substr($src_dir, 0, strlen($src_dir) - 1);
	if(($slash = substr($dst_dir, -1)) == "\\" || $slash == "/") $dst_dir = substr($dst_dir, 0, strlen($dst_dir) - 1);
	if (!$use_cached_dir_trees || !isset($src_tree) || $cached_src_dir != $src_dir)
	{
		$src_tree = get_dir_tree($src_dir,true,$UploadDate);
		$cached_src_dir = $src_dir;
		$src_changed = true;
	}
	if (!$use_cached_dir_trees || !isset($dst_tree) || $src_changed)
		$dst_tree = get_dir_tree($dst_dir,true,$UploadDate);
	if (!is_dir($dst_dir)) mkdir($dst_dir, 0777, true);

	foreach ($src_tree as $file => $src_mtime) {
		if (!isset($dst_tree[$file]) && $src_mtime === false) {
			mkdir("$dst_dir/$file");
		} elseif (!isset($dst_tree[$file]) && $src_mtime || isset($dst_tree[$file]) && $src_mtime > $dst_tree[$file]) {
			if (copy("$src_dir/$file", "$dst_dir/$file")) {
				if($verbose) {
					echo "Copied '$src_dir/$file' to '$dst_dir/$file'<br>\r\n";
				}
				touch("$dst_dir/$file", strToTime($src_mtime) );
				$num++;
			} else
				echo "<font color='red'>File '$src_dir/$file' could not be copied!</font><br>\r\n";
		}
	}
	return $num;
}
function get_dir_tree($dir, $root = true,$UploadDate) {
	static $tree;
	static $base_dir_length;

	if ($root)
	{
		$tree = array();
		$base_dir_length = strlen($dir) + 1;
	}

	if (is_file($dir))
	{
		if($UploadDate!=false)
		{
			if(filemtime($dir)>strtotime($UploadDate))
				$tree[substr($dir, $base_dir_length)] = date('Y-m-d H:i:s',filemtime($dir));   
		}
		else
			$tree[substr($dir, $base_dir_length)] = date('Y-m-d H:i:s',filemtime($dir));
	}
	elseif ((is_dir($dir) && substr($dir, -4) != ".svn") && $di = dir($dir) )
	{
		if (!$root) $tree[substr($dir, $base_dir_length)] = false;
		while (($file = $di->read()) !== false)
			if ($file != "." && $file != "..")
				get_dir_tree("$dir/$file", false,$UploadDate);
		$di->close();
	}
	if ($root)
		return $tree;   
}
function isFile( $file ) {
	if ( 0 === strpos( $file, 'http' ) ) {
		$headers = get_headers($file);
		return ! ! preg_match( '/200 OK$/', current( $headers ) );
	}
	return is_file( $file );
}
/************************ geo_ip *************************/
function get_geo_ip_code($ipaddr) {
	   return file_get_contents("http://geoip.wtanaka.com/cc/$ipaddr");
}
function geoip($ip = "127.0.0.1"){
	if($ip == "127.0.0.1") {
		$ip = $_SERVER["REMOTE_ADDR"];
	}

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,'http://www.geoplugin.net/php.gp?ip='.$ip);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	$curl = curl_exec($ch);
	curl_close($ch);

	$geoip = unserialize($curl);
	return $geoip["geoplugin_countryName"]." ".$geoip["geoplugin_city"];//return country and city
}
function strcut($str, $len){
	preg_match('/([\x00-\x7e]|..)*/', substr($str, 0, $len), $rv);
	return $rv[0];
} 
// matheus at slacklife dot com dot br
// Image Resize
function createthumb($IMAGE_SOURCE,$THUMB_X,$THUMB_Y,$OUTPUT_FILE){
	$BACKUP_FILE = $OUTPUT_FILE . "_backup.jpg";
	copy($IMAGE_SOURCE,$BACKUP_FILE);
	$IMAGE_PROPERTIES = GetImageSize($BACKUP_FILE);
	if (!$IMAGE_PROPERTIES[2] == 2) {
		return(0);
	} else {
		$SRC_IMAGE = ImageCreateFromJPEG($BACKUP_FILE);
		$SRC_X = ImageSX($SRC_IMAGE);
		$SRC_Y = ImageSY($SRC_IMAGE);
		if (($THUMB_Y == "0") && ($THUMB_X == "0")) {
			return(0);
		} elseif ($THUMB_Y == "0") {
			$SCALEX = $THUMB_X/($SRC_X-1);
			$THUMB_Y = $SRC_Y*$SCALEX;
		} elseif ($THUMB_X == "0") {
			$SCALEY = $THUMB_Y/($SRC_Y-1);
			$THUMB_X = $SRC_X*$SCALEY;
		}
		$THUMB_X = (int)($THUMB_X);
		$THUMB_Y = (int)($THUMB_Y);
		$DEST_IMAGE = imagecreatetruecolor($THUMB_X, $THUMB_Y);
		unlink($BACKUP_FILE);
		if (!imagecopyresized($DEST_IMAGE, $SRC_IMAGE, 0, 0, 0, 0, $THUMB_X, $THUMB_Y, $SRC_X, $SRC_Y)) {
			imagedestroy($SRC_IMAGE);
			imagedestroy($DEST_IMAGE);
			return(0);
		} else {
			imagedestroy($SRC_IMAGE);
			if (ImageJPEG($DEST_IMAGE,$OUTPUT_FILE)) {
				imagedestroy($DEST_IMAGE);
				return(1);
			}
			imagedestroy($DEST_IMAGE);
		}
		return(0);
	}

} # end createthumb
function getExtension ( $fileName ) {
	$rv = strToLower( array_pop( explode( '.', $fileName ) ) );
	return $rv;
}
function MadErrorHandler($errno, $errstr, $errfile, $errline) {
	switch ($errno) {
		case E_USER_ERROR:
			echo "<b>My ERROR</b> [$errno] $errstr<br />\n";
			echo "  Fatal error on line $errline in file $errfile";
			echo ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
			echo "Aborting...<br />\n";
			exit(1);
			break;

		case E_USER_WARNING:
			echo "<b>My WARNING</b> [$errno] $errstr<br />\n";
			break;

		case E_USER_NOTICE:
			echo "<b>My NOTICE</b> [$errno] $errstr<br />\n";
			break;

		default:
			echo "Unknown error type: [$errno] $errstr<br />\n";
			break;
	}

	/* Don't execute PHP internal error handler */
	return true;
}
function getBackUrl() {
	$url = parse_url( $_SERVER['HTTP_REFERER'] );
	return $url['path'] . '?' . $url['query'];
}
function file_get_contents_csv( $fileName ) {
	$rv = array();
	if ( ( $handle = fopen($fileName, 'r') ) !== false ) {
		while( $row = fgetcsv($handle) ) {
			$rv[] = $row;
		}
	}
	return $rv;
}
function ckTime() {
	$current = microtime(true);
	if ( isset( $GLOBALS['phpCheckTime'] ) ) {
		print $GLOBALS['phpCheckTime'] . ' => ';
		print $current - $GLOBALS['phpCheckTime'];
		print BR;
	}
	$GLOBALS['phpCheckTime'] = $current;
}
function encode_2047($subject) {
	return '=?euc-kr?b?'.base64_encode($subject).'?=';
}

function camel2underscore($str) {
	$str[0] = strtolower($str[0]);
	$func = create_function('$c', 'return "_" . strtolower($c[1]);');
	return preg_replace_callback('/([A-Z])/', $func, $str);
}

/**
 * Translates a string with underscores into camel case (e.g. first_name -&gt; firstName)
 * @param    string   $str                     String in underscore format
 * @param    bool     $capitalise_first_char   If true, capitalise the first char in $str
 * @return   string                              $str translated into camel caps
 */
function underscore2camel($str, $capitalise_first_char = false) {
	if($capitalise_first_char) {
		$str[0] = strtoupper($str[0]);
	}
	$func = create_function('$c', 'return strtoupper($c[1]);');
	return preg_replace_callback('/_([a-z])/', $func, $str);
}
function rmDirAll( $dir ) {
	if ( ! is_dir( $dir ) ) {
		throw new Exception( $dir . ' is not a directory.' );
	}
	$files = glob( $dir . '/*', GLOB_MARK );
	foreach ( $files as $file ) {
		if( substr( $file, -1 ) == '/' ) {
			rmDirAll( $file );
		} else {
			unlink( $file );
		}
	}
	rmDir( $dir );
} 
if(function_exists('lcFirst') === false) {
	function lcFirst($str) {
		$str[0] = strtolower($str[0]);
		return $str;
	}
}
/*************************** string related ************************/
function utf8_length($str) {
	$len = strlen($str);
	for ($i = $length = 0; $i < $len; $length++) {
		$high = ord($str{$i});
		if ($high < 0x80) {
			$i += 1;
		} else if ($high < 0xE0) {
			$i += 2;
		} else if ($high < 0xF0) {
			$i += 3;
		} else {
			$i += 4;
		}
	}
	return $length;
}
function utf8_strcut($str, $chars, $tail = '') {  
	if ( utf8_length($str) <= $chars) {
		$tail = '';
	} else {
		$chars -= utf8_length($tail);
	}
	$len = strlen($str);
	for ($i = $adapted = 0; $i < $len; $adapted = $i) {
		$high = ord($str{$i});
		if ($high < 0x80)
			$i += 1;
		else if ($high < 0xE0)
			$i += 2;
		else if ($high < 0xF0)
			$i += 3;
		else
			$i += 4;
		if (--$chars < 0)
			break;
	}
	return trim(substr($str, 0, $adapted)) . $tail;
}
/***************************** date ****************************/
function date_format2($str){
	return substr($str, 0, 4) . "-" . substr($str, 4, 2) . "-" . substr($str, 6, 2);
}
function isDate( $date ) {
	if ( preg_match('/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/', $date) ) {
		return true;
	}
	return false;
}

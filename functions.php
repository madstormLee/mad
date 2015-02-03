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
function printRuntime() {
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
	return isset($a) && $a == $b;
}
function test( $testName ) {
	include "tests/$testName.php";
	$test = new $testName;
	foreach( $test as $action ) {
		$test->$action();
	}
}
function printPre( $data ) {
	print '<pre class="printPre">';
	print $data;
	print '</pre>';
}
if ( ! function_exists( 'printR' ) ) {
	function printR( $data, $option=false ) {
		$rv = '<pre class="printR">';
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
		print '<pre class="varDump">';
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

/************************ file ************************/
function formatBytes($bytes, $precision = 2) { 
	$units = array('B', 'KB', 'MB', 'GB', 'TB'); 

	$bytes = max($bytes, 0); 
	$pow = floor(($bytes ? log($bytes) : 0) / log(1024)); 
	$pow = min($pow, count($units) - 1); 

	$bytes /= pow(1024, $pow);

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
/************************ geo_ip *************************/
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
function ckTime() {
	$current = microtime(true);
	if ( isset( $GLOBALS['phpCheckTime'] ) ) {
		print $GLOBALS['phpCheckTime'] . ' => ';
		print $current - $GLOBALS['phpCheckTime'];
		print BR;
	}
	$GLOBALS['phpCheckTime'] = $current;
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
if ( ! function_exists('globR')) {
	function globR($pattern, $flags = 0) {
		$files = glob($pattern, $flags);

		foreach (glob(dirname($pattern).'/*', GLOB_ONLYDIR|GLOB_NOSORT) as $dir) {
			$files = array_merge($files, globR($dir.'/'.basename($pattern), $flags));
		}

		return $files;
	}
}
/***************************** date ****************************/
function isDate( $date ) {
	if ( preg_match('/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/', $date) ) {
		return true;
	}
	return false;
}

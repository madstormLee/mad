<?
class MadFile {
	function __construct(){
	}
	function scan($dirname,$kind='dir'){
		$kind = 'is_'.$kind;
		$rv = '';

		$dir=scandir($dirname);

		foreach($dir as $value){
			if($kind($value)){
				$rv[] = $value;
			}
		}
		return $rv;
	}
	function rm($filename, $options) {
		if ( is_dir($filename) ) {
			return rmdir($filename);
		} else {
			return unlink($filename);
		}
	}
}

<?
class Sqlite extends MadModel {
	protected $dir = '.';
	protected $functions = array("abs", "hex", "length", "lower", "ltrim", "random", "round", "rtrim", "trim", "typeof", "upper");
	protected $customFunctions = array();
	protected $extensions = array("db","db3","sqlite","sqlite3");
	protected $datatypes = array("INTEGER", "REAL", "TEXT", "BLOB","NUMERIC","BOOLEAN","DATETIME");

	function __construct() {
		// this will be refactoring.
		$config = MadConfig::getInstance();
		$info = $config->info;
		if ( isset( $info->custom_functions ) ) {
			$this->customFunctions = $info->custom_functions;
		}
		if ( isset( $info->allow_extensions ) ) {
			$this->extensions = $info->allow_extensions;
		}
		if ( isset( $info->dir ) ) {
			$this->setDir( $info->dir );
		}
	}
	function rename( $oldname, $newpath ) {
		rename($oldname, $newpath);
		$databases[$checkDB]['path'] = $newpath;
		$databases[$checkDB]['name'] = basename($newpath);
		$_SESSION['currentDB'] = $databases[$checkDB]; 
	}
	function setDir( $dir ) {
		$this->dir = $dir;
		return $this;
	}
	function checkDbName($name) {
		$file = new MadFile( $name );
		$ext = $file->getExtension();
		if( ! in_array($ext, $this->extensions)) {
			return false;
		}
		return $file->exists();
	}
	function isManagedDb( $path ) {
		if ( empty( $path ) ) {
			return false;
		}
		foreach($this->databases() as $db_key => $database) {
			if($path == $database['path']) {
				return true;
			}
		}
		return false;
	}
	function getSession() {
		return ckKey('currentDB', $_SESSION); 
	}
	function checkSession() {
		$sessionDb = $this->getSession();
		if( $sessionDb && ! $this->model->isManagedDb($sessionDb['path']) ) {
			unset($_SESSION['currentDB']);
		}
	}
	function databases() {
		$dir = new MadDir($this->dir, '*.db');

		$rv = array();
		for( $dir as $file ) {
			if ( ! $file->isFile() ) continue;
			if ( ! $this->isSqlite( $file ) ) continue;

			$row = array();
			$row['path'] = $arr[$i];
			$row['name'] = $file->getBasename();
			$row['writable'] = is_writable($file);
			$row['writable_dir'] = is_writable(dirname($file));
			$row['readable'] = is_readable($file);
			$rv[] = $row;
		}
		sort($rv);
		return $rv;
	}
	function isSqlite( $file ) {
		$con = file_get_contents($file, NULL, NULL, 0, 60);
		return strpos($con, "** This file contains an SQLite 2.1 database **", 0)!==false || strpos($con, "SQLite format 3", 0)!==false;
	}
	function setCustomFunctions( $customFunctions = array() ) {
		$this->customFunctions = $customFunctions;
	}
	function functions() {
		return array_merge( $this->functions, $this->customFunctions );
	}
	function datatypes() {
		return $this->datatypes;
	}
}

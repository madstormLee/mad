<?
class MadFile implements IteratorAggregate {
	protected $file = '';

	protected $info = null;
	protected $data = array();
	protected $filter = array();

	protected $contents = '';
	protected $mod = '0777';

	function __construct( $target = '' ) {
		$this->setFile( $target );
	}
	// for subclassing.
	public static function create( $file ) {
		if ( preg_match( '/\.html$/', $file ) ) {
			return new MadView( $file );
		} elseif ( preg_match( '/\.json$/', $file ) ) {
			return new MadJson( $file );
		}
		return new MadFile( $file );
	}
	function isEmpty() {
		return ( empty( $this->data ) );
	}
	function setFile( $target ) {
		$this->file = $target;
		return $this;
	}
	function getFile() {
		return $this->file;
	}
	function exists() {
		return file_exists( $this->file );
	}
	function isImage() {
		return exif_imagetype( $this->file );
	}
	function isText() {
		if ( preg_match( '(txt|css|js|json|php)$',$this->file ) ) {
			return true;
		}
		$info = new finfo( FILEINFO_MIME );
		return substr( $info->file( $this->file ), 0, 4 ) == 'text';
	}
	function isBinary() {
		return ! $this->isText();
	}
	function isFile() {
		if ( 0 === strpos( $this->file, 'http' ) ) {
			$headers = get_headers($this->file);
			return ! ! preg_match( '/200 OK$/', current( $headers ) );
		}
		return is_file( $this->file );
	}
	function isDir() {
		return is_dir( $this->file );
	}
	function remove() {
		if( $this->isDir() ) {
			return rmDir( $this->file );
		} else if( $this->isFile() ) {
			return unlink( $this->file );
		}
		return false;
	}
	function removeDirAll( $dir='' ) {
		if ( empty( $dir ) ) {
			$dir = $this->dir;
		}
		if ( ! is_dir( $dir ) ) {
			throw new Exception( $dir . ' is not a directory.' );
		}
		$files = glob( $dir . '/*', GLOB_MARK );
		foreach ( $files as $file ) {
			if( substr( $file, -1 ) == '/' ) {
				$this->removeAll( $file );
			} else {
				unlink( $file );
			}
		}
		rmDir( $dir );
	}
	function delete() {
		return $this->remove();
	}
	function getName() {
		return baseName( $this->file );
	}
	function getExtension() {
		$temp = explode( '.', $this->getName() );
		return array_pop( $temp );
	}
	function setInfo() {
		$this->info = new SplFileInfo( $this->file );
		return $this;
	}
	function getInfo() {
		if ( ! $this->info instanceof SplFileInfo ) {
			$this->setInfo();
		}
		return $this->info;
	}
	function save( $contents = '' ) {
		if ( $this->getExtension() ) {
			return $this->saveFile( $contents );
		} else {
			return $this->saveDir();
		}
	}
	function saveAs( $target ) {
		$this->contents = $this->getContents();
		$this->file = $target;

		$dir = dirname( $this->file );
		if ( ! is_dir( $dir ) ) {
			mkdir( $dir, 0755, true );
			chmod( $dir, 0755 );
		}

		$result = file_put_contents( $this->file, $this->contents );
		@chmod( $this->file, 0755 );
		return $result;
	}
	function saveFile( $contents='' ) {
		if ( ! empty( $contents ) ) {
			$this->contents = $contents;
		}
		$result = file_put_contents( $this->file, $this->contents );
		@chmod( $this->file, 0755 );
		return $result;
	}
	/******************************* for dir ***************************/
	function saveDir() {
		if ( $this->isDir() ) {
			return $this;
		}
		@mkdir( $this->file, 0755, true );
		@chmod( $this->file, 0755 );
		return $this;
	}
	function filter( $filter ) {
		$this->filter = $filter;
		return $this;
	}
	function scan() {
		if ( ! empty( $this->data ) ) {
			return $this;
		}
		if ( ! $this->isDir() ) {
			return $this;
		}

		$files = scandir( $this->file );

		foreach( $files as $file ) {
			if ( ! empty( $this->filter ) && preg_match( "/$this->filter/", $file ) ) {
				continue;
			}
			if ( $this->file === '.' ) {
				$this->data[] = new MadFile( $file );
			} else {
				$this->data[] = new MadFile( $this->file . '/' . $file );
			}
		}

		return $this;
	}
	function getIterator() {
		if ( $this->isDir() ) {
			$this->scan();
			return new ArrayIterator( $this->data );
		}
		return new ArrayIterator( file( $this->file ) );
	}
	function getContents() {
		return file_get_contents( $this->file );
	}
	function getSource() {
		return show_source( $this->file, true );
	}
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
	function rename( $name ) {
		if ( ( ! $this->isFile() ) ||
				( ! $this->isWritable() )
		   ) {
			return false;
		}
		$target = $this->getFile();
		$dest = dirName( $target ) . '/' . $name;
		if ( ! rename( $target, $dest ) ) {
			return false;
		}
		$this->file = $dest;
		return $this;
	}
	function __toString() {
		return $this->getContents();
	}
	function __call( $method, $args ) {
		$info = $this->getInfo();
		if ( $info instanceof SplFileInfo ) {
			return call_user_func_array(
					array( $info, $method ),
					$args);
		}
		throw new Exception("There is no $method method in " . get_class($this) . "." );
	}
	function getDirTree($dir, $root = true,$UploadDate) {
		static $tree;
		static $base_dir_length;

		if ($root) {
			$tree = array();
			$base_dir_length = strlen($dir) + 1;
		}

		if (is_file($dir)) {
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
					$this->getDirTree("$dir/$file", false,$UploadDate);
			$di->close();
		}
		if ($root)
			return $tree;   
	}
	// from : jyotsnachannagiri@gmail.com 
	function copyDir($src_dir, $dst_dir,$UploadDate=false, $verbose = false, $use_cached_dir_trees = false) {
		static $cached_src_dir;
		static $src_tree;
		static $dst_tree;
		$num = 0;

		if(($slash = substr($src_dir, -1)) == "\\" || $slash == "/") $src_dir = substr($src_dir, 0, strlen($src_dir) - 1);
		if(($slash = substr($dst_dir, -1)) == "\\" || $slash == "/") $dst_dir = substr($dst_dir, 0, strlen($dst_dir) - 1);
		if (!$use_cached_dir_trees || !isset($src_tree) || $cached_src_dir != $src_dir)
		{
			$src_tree = $this->getDirTree($src_dir,true,$UploadDate);
			$cached_src_dir = $src_dir;
			$src_changed = true;
		}
		if (!$use_cached_dir_trees || !isset($dst_tree) || $src_changed)
			$dst_tree = $this->getDirTree($dst_dir,true,$UploadDate);
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
}

<?
class MadDir extends MadFile {
	protected $data = array();
	protected $dir = '';
	protected $pattern = '*';
	protected $flag = 0;

	function __construct( $dir = '' ) {
		$this->setDir( $dir );
	}
	function setDir( $dir ) {
		$this->dir = $dir;
		return $this;
	}
	function getDir() {
		return $this->dir;
	}
	function getParentDir() {
		return dirName( $this->dir );
	}
	function setPattern( $pattern ) {
		$this->pattern = $pattern;
		return $this;
	}
	function getPattern( $pattern ) {
		return $this->pattern;
	}
	function scan() {
		if ( ! empty( $this->data ) ) {
			return $this;
		}
		foreach( $this->getIndex() as $file ) {
			$this->data[$file] = new MadFile( $file );
		}

		return $this;
	}
	function setFlag( $flag ) {
		$this->flag = $flag;
		return $this;
	}
	function getIndex() {
		if ( $this->dir == '' ) {
			$target = "$this->pattern";
		} else {
			$target = "$this->dir/$this->pattern";
		}
		$rv = array();
		foreach( glob( $target, $this->flag ) as $file ) {
			$rv[] = new MadFile( $file );
		}
		return $rv;
	}
	function save() {
		if ( ! $this->isDir() ) {
			mkdir( $dir, 0755, true );
			chmod( $dir, 0755 );
		}
		return $this;
	}
	function getIterator() {
		return new ArrayIterator( $this->getIndex() );
	}
	/***************** utilities *****************/
	function getTree($dir, $root = true,$UploadDate) {
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
					$this->getTree("$dir/$file", false,$UploadDate);
			$di->close();
		}
		if ($root)
			return $tree;   
	}
	// from : jyotsnachannagiri@gmail.com 
	function copy($src_dir, $dst_dir,$UploadDate=false, $verbose = false, $use_cached_dir_trees = false) {
		static $cached_src_dir;
		static $src_tree;
		static $dst_tree;
		$num = 0;

		if(($slash = substr($src_dir, -1)) == "\\" || $slash == "/") $src_dir = substr($src_dir, 0, strlen($src_dir) - 1);
		if(($slash = substr($dst_dir, -1)) == "\\" || $slash == "/") $dst_dir = substr($dst_dir, 0, strlen($dst_dir) - 1);
		if (!$use_cached_dir_trees || !isset($src_tree) || $cached_src_dir != $src_dir)
		{
			$src_tree = $this->getTree($src_dir,true,$UploadDate);
			$cached_src_dir = $src_dir;
			$src_changed = true;
		}
		if (!$use_cached_dir_trees || !isset($dst_tree) || $src_changed)
			$dst_tree = $this->getTree($dst_dir,true,$UploadDate);
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
	function deleteAll( $dir='' ) {
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
	function __toString() {
		return $this->dir;
	}
}

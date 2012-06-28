<?
class MadDir extends Mad implements IteratorAggregate {
	protected $data = array();
	protected $type;
	protected $dir;
	protected $filter = array();
	protected $recursive = false;

	function __construct( $dir = '' ) {
		$this->setDir( $dir );
	}
	function setDir( $dir ) {
		if ( is_dir ( $dir ) ) {
			$this->dir = realpath( $dir ) . '/';
		}
		return $this;
	}
	function getDir() {
		return $this->dir;
	}
	function setRecursive( $recursive ) {
		$this->recursive = $recursive;
		return $this;
	}
	function getRecursive() {
		return $this->recursive;
	}
	function setType( $type = '' ) {
		if ( ! empty( $type ) ) {
			$this->type = $type;
		}
		return $this;
	}
	function getType() {
		return $this->type;
	}
	function get() {
		if ( empty( $this->data ) ) {
			$this->setData();
		}
		return $this->data;
	}
	function isEmpty() {
		return empty( $this->data );
	}
	function setFilter( $filter ) {
		$this->filter = explode(',', $filter );
		return $this;
	}
	function setData() {
		$rv = array();
		if ( ! is_dir( $this->dir ) ) {
			return $this;
		}
		$files = scandir( $this->dir );
		foreach( $files as $file ) {
			$path = $this->dir . $file;
			if ( in_Array( 'dirs', $this->filter ) &&
				! is_dir( $path ) ) {
					continue;
			}
			if ( in_array( 'noUp', $this->filter ) &&
				0 === strpos($file,  '.') ) {
				continue;
			}
			if ( $this->recursive && is_dir( $path ) ) {
				$rv[$file] = $this->getSubDir( $path );
			}
			if ( $this->type && ! preg_match( "/$this->type/", $file ) ) {
				continue;
			}
			$rv[] = $path;
		}
		$this->data = $rv;
		return $this;
	}
	private function getSubDir( $path ) {
		$subDir = new MadDir( $path . '/' );
		
		$rv = array();
		foreach( $subDir->setType( $this->type ) as $path ) {
			$rv[] = $path;
		}
		return $rv;
	}
	function getIterator() {
		return new ArrayIterator( $this->get() );
	}
	function test() {
		print $this->dir;
		printR( $this->data );
	}
	function __toString() {
		// MadDirView가 필요하다.
		$rv = "";
		foreach( $this as $file ) {
			$rv .= $file . BR;
		}
		return $rv;
	}
}

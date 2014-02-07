<?
class MadDir implements IteratorAggregate {
	protected $data = array();
	protected $dir;

	function __construct( $dir = '' ) {
		$this->setDir( $dir );
	}
	function setDir( $dir ) {
		if ( is_dir ( $dir ) ) {
			$this->dir = $dir;
		}
		return $this;
	}
	function getDir() {
		return $this->dir;
	}
	function isEmpty() {
		return empty( $this->data );
	}
	function filter( $filter ) {
		$this->filter = $filter;
		return $this;
	}
	private function checkFilter( $file ) {
		return ! empty( $this->filter ) && ! preg_match( "/$this->filter/", $file );
	}
	function scan() {
		if ( ! empty( $this->data ) ) {
			return $this;
		}
		if ( ! is_dir( $this->dir ) ) {
			return $this;
		}
		$files = scandir( $this->dir );

		foreach( $files as $file ) {
			$this->data[] = new MadFile( $this->dir . $file );
		}

		return $this;
	}
	function save() {
		if ( ! is_dir ( $dir ) ) {
			mkdir( $dir, 0755, true );
			chmod( $dir, 0755 );
		}
		return $this;
	}
	function getIterator() {
		if ( $this->isEmpty() ) {
			$this->scan();
		}
		return new ArrayIterator( $this->data );
	}
	function test() {
		print $this->dir;
		$this->scan();
		(new MadDebug)->printR( $this->data );
	}
	function __toString() {
		return $this->dir;
	}
}

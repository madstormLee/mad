<?
class MadModel extends MadAbstractData {
	protected $data = array();

	public static final function create( $class, $file = null ) {
		$class = ucFirst( $class );
		return class_exists( $class )? new $class($file): new self($file);
	}
	function __construct( $file = '' ) {
		$this->setting( $file );
	}
	function setting( $file ) {
		if ( ! is_file($file) ) {
			return false;
		}
		$setting = new MadJson( $file );
		foreach( $setting as $key => $value ) {
			$this->$key = $value;
		}
		return $this;
	}
	function fetch( $id = '' ) {
		if ( empty( $id ) ) {
			return false;
		}
		$this->id = $id;
	}

	function save( $data = array() ) {
	}
	function delete( $id = '' ) {
	}
	function getList() {
		return new ArrayIterator( array() );
	}
	function __toString() {
		return $this->id;
	}
}

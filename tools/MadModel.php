<?
class MadModel extends MadAbstractData {
	protected $data = array();

	public static final function create( $class, $file = null ) {
		$class = ucFirst( $class );
		return class_exists( $class )? new $class($file): new self($file);
	}
	function __construct( $file = '' ) {
	}
	function getIndex() {
		$dir = new MadDir;
		return $dir;
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
	function __toString() {
		return $this->id;
	}
}

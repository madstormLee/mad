<?
class MadUser implements IteratorAggregate {
	protected $data = array();
	protected $levels = null;
	protected $level = 1000;

	function __construct( $id='' ) {
		$this->levels = new MadData( array(
			'root' => 0,
			'admin' => 1,
			'localAdmin' => 5,
			'member' => 200,
			'user' => 255,
			'default' => 1000,
		) );
		$this->fetch( $id );
	}
	function fetch( $id ) {
		if ( empty( $id ) ) {
			return $this;
		}
		$json = new MadJson( "user/data/$id.json" );
		$this->data = $json->getData();
		$this->setLevel( $json->level );
		return $this;
	}
	function fetchLogin( $id, $pw ) {
		$this->fetch( $id );
		if ( $this->password != sha1( $pw ) ) {
			throw new Exception('Wrong id/password.');
		}
		return $this;
	}
	function setLevel( $level = 1000 ) {
		$this->level = $level;
		return $this;
	}
	function getLevel( $name = '' ) {
		if ( empty( $name ) ) {
			return $this->level;
		}
		return $this->levels->$name;
	}
	function getDefaultLevel() {
		if ( ! $this->levels->default ) {
			$this->levels->default = 300;
		}
		return $this->levels->default;
	}
	function getIterator() {
		return new ArrayIterator($this->data);
	}
	function __get( $key ) {
		if ( isset( $this->data[$key] ) ) {
			return $this->data[$key];
		}
		return false;
	}
}

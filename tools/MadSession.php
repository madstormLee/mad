<?
// singleton이 아니다.
class MadSession {
	protected static $instance = null;
	protected $data;
	protected $sessId;

	public function __construct( $sessId = '' ) {
		if ( empty( $sessId ) ) {
			$this->data = &$_SESSION;
			return;
		}
		$this->sessId = $sessId;
		if ( ! isset( $_SESSION[$sessId] ) ) {
			$_SESSION[$sessId] = array();
		}
		$this->data = &$_SESSION[$sessId];
	}
	public static function getInstance() {
		if ( ! self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}
	function __set($key, $value) {
		$this->data[$key] = $value;
	}
	function __get($key) {
		if ( isset ($this->data[$key]) ) {
			return $this->data[$key];
		}
		return null;
	}
	function isEmpty() {
		return empty( $this->data );
	}
	function __isset( $key ) {
		if( isset($this->data[$key] ) ) {
			return true;
		}
	}
	function __unset( $key ) {
		if( isset( $this->data[$key] ) ) {
			unset( $this->data[$key] );
			return true;
		}
		return false;
	}
	function add( $data ) {
		return $this->addData( $data );
	}
	function addData( $data ) {
		if ( ! isArray( $data ) ) {
			$data = (array) $data;
		}
		foreach( $data as $key => $value ) {
			$this->data[$key] = $value;
		}
		return $this;
	}
	function set( $data ) {
		$this->data = $data;
		return $this;
	}
	function get($key='') {
		if ($key === '' and isset($this->data)) {
			return $this->data;
		} else {
			return $this->__get($key);
		}
	}
	function getTotal() {
		if ( isset($this->data) ) {
			return count( $this->data );
		}
		return 0;
	}
	function remove($key) {
		if ( isset($this->data[$key]) ) {
			unset($this->data[$key]);
			return true;
		}
		return false;
	}
	function clear() {
		return $this->destroy();
	}
	function destroy() {
		if ( isset( $this->data ) ) {
			$this->data = array();
		}
		return $this;
	}
	function test() {
		printR( $this->data );
	}
	function testAll() {
		printR( $_SESSION );
	}
	function __toString() {
	}
	function __call($method, $args) {
		print $method . ' method is not in ' . $this->className . '.';
	}
}

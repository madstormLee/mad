<?
class MadSingletonData implements ArrayAccess, IteratorAggregate {
	protected $data = array();

	protected function __construct() {
	}
	/* for Singleton pattern this method must implement */
	public static function getInstance() {
	}
	function get() {
		return $this->getData();
	}
	function set( $data ) {
		return $this->setData( $data );
	}
	function setData( $data = array() ) {
		foreach( $data as $key => $unit ) {
			if ( is_array( $unit ) ) {
				$data[$key] = new MadData( $unit );
			}
		}
		$this->data = $data;
		return $this;
	}
	function getData() {
		return $this->data;
	}
	function getDictionary( $target, $target2 = '' ) {
		foreach( $this->data as $key => $row ) {
			if ( $target2 == 'reverse' ) {
				$rv[$row->$target] = $key;
			} else if ( ! empty( $target2 ) ) {
				$rv[$row->$target] = $row->$target2;
			} else {
				$rv[$key] = $row->$target;
			}
		}
		return $rv;
	}
	function __get( $key ) {
		if ( ! isset( $this->data[$key] ) ) {
			return false;
		}
		return $this->data[$key];
	}
	function __set( $key, $value ) {
		if ( is_array( $value ) ) {
			$this->data[$key] = new MadData($value);
		} else {
			$this->data[$key] = $value;
		}
	}
	function __unset($key) {
		if ( isset( $this->data[$key] ) ) {
			unset( $this->data[$key] );
		}
	}
	function __isset( $key ) {
		if ( isset( $this->data[$key] ) ) {
			return true;
		}
		return false;
	}
	public function isEmpty() {
		return empty( $this->data );
	}
	public function getArray() {
		return $this->data;
	}
	public function getIterator() {
		return new ArrayIterator($this->data);
	}
	public function offsetSet($offset, $value) {
		$this->data[$offset] = $value;
	}
	public function offsetUnset($offset) {
		unset($this->data[$offset]);
	}
	public function offsetExists($offset) {
		return isset($this->data[$offset]);
	}
	public function offsetGet($offset) {
		return isset($this->data[$offset]) ? $this->data[$offset] : null;
	}
	public function __toString() {
		if ( empty( $this->data ) ) {
			return '';
		}
		return array_pop( $this->data );
	}
	function test() {
		printR($this->data);
		return $this;
	}
}

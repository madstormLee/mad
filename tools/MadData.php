<?
class MadData implements ArrayAccess, IteratorAggregate {
	protected $data = array();

	function __construct( $data = array() ) {
		$this->setData( $data );
	}
	function get() {
		return $this->getData();
	}
	function set( $data = array() ) {
		return $this->setData( $data );
	}
	function add( $value ) {
		$this->data[] = $value;
	}
	function setData( $data = array() ) {
		$this->data = array();
		$this->addData( $data );
		return $this;
	}
	function getData() {
		return $this->data;
	}
	function clear() {
		$this->data = array();
		return $this;
	}
	function count() {
		return count( $this->data );
	}
	function addData( $data = array() ) {
		foreach( $data as $key => $unit ) {
			if ( is_array( $unit ) ) {
				$this->data[$key] = new self( $unit );
			} else {
				$this->data[$key] = $unit;
			}
		}
		return $this;
	}
	function filter( $callback = '' ) {
		if ( $callback ) {
			$this->data = array_filter( $this->data, $callback );
		} else {
			$this->data = array_filter( $this->data );
		}
		return $this;
	}
	function getDictionary( $target, $target2 = '' ) {
		$rv = array();
		foreach( $this->data as $key => $row ) {
			if ( ! empty( $target2 ) ) {
				$rv[$row[$target]] = $row[$target2];
			} else {
				$rv[$key] = $row[$target];
			}
		}
		return new MadData( $rv );
	}
	function getReverseDictionary( $target ) {
		$rv = array();
		foreach( $this->data as $key => $row ) {
			$rv[$row->$target] = $key;
		}
		return new self( $rv );
	}
	function __get( $key ) {
		if ( ! isset( $this->data[$key] ) ) {
			return false;
		}
		return $this->data[$key];
	}
	function __set( $key, $value ) {
		if ( is_array( $value ) ) {
			$this->data[$key] = new self( $value );
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
	function json() {
		return json_encode( $this->getArray() );
	}
	public function isEmpty() {
		return empty( $this->data );
	}
	public function getArray() {
		$rv = array();
		foreach( $this->data as $key => $value ) {
			if ( $value instanceof self ) {
				$rv[$key] = $value->getArray();
			} else {
				$rv[$key] = $value;
			}
		}
		return $rv;
	}
	public function getIterator() {
		return new ArrayIterator( $this->getData() );
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
	public function end() {
		return end( $this->data );
	}
	public function __toString() {
		if ( empty( $this->data ) ) {
			return '';
		}
		return current( $this->data );
	}
	function test() {
		printR($this->data);
		return $this;
	}
}

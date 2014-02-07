<?
abstract class MadAbstractData implements IteratorAggregate, ArrayAccess, Countable {
	protected $data = array();

	function index( $key ) {
		$rv = array();
		foreach( $this->data as &$row ) {
			$rv[$row->$key] = $row;
		}
		$this->data = $rv;
		return $this;
	}
	function get( $key ) {
		if ( ! isset( $this->data[$key] ) ) {
			return new MadNull;
		}
		return $this->data[$key];
	}
	function set( $key, $value ) {
		if ( $key === null ) {
			return $this->add( $value );
		}
		if ( is_array( $value ) ) {
			$value = new MadData( $value );
		}
		$this->data[$key] = $value;
		return $this;
	}
	function addSlashes() {
		foreach( $this->data as &$value ) {
			$value = addSlashes( $value );
		}
		return $this;
	}
	function add( $value ) {
		if ( is_array( $value ) ) {
			$value = new MadData( $value );
		}
		$this->data[] = $value;
		return $this;
	}
	function getData() {
		return $this->data;
	}
	function setData( $data = null ) {
		$this->data = array();
		return $this->addData( $data );
	}
	function addData( $data = null ) {
		if ( empty( $data ) ) {
			return $this;
		}
		foreach( $data as $key => $value ) {
			if ( is_array( $value ) ) {
				$this->data[$key] = new MadData( $value );
			} else {
				$this->data[$key] = $value;
			}
		}
		return $this;
	}
	function clear() {
		$this->data = array();
		return $this;
	}
	public function getArray() {
		$rv = array();
		if ( $this->isEmpty() ) {
			return $rv;
		}

		foreach( $this->data as $key => $value ) {
			if ( $value instanceof MadData ) {
				$rv[$key] = $value->getArray();
			} else {
				$rv[$key] = $value;
			}
		}
		return $rv;
	}
	function in( $value ) {
		return in_array( $value, $this->data );
	}
	function exists( $key ) {
		return array_key_exists( $key, $this->data );
	}
	/*********************** array_somethings *************************/
	function push( $value ) {
		array_push( $this->data, $value );
		return $this;
	}
	function pop() {
		return array_pop( $this->data );
	}
	function unshift( $value ) {
		array_unshift( $this->data, $value );
		return $this;
	}
	function unique() {
		$this->data = array_unique( $this->data );
		return $this;
	}
	function sum() {
		return array_sum( $this->data );
	}
	function search( $value ) {
		return array_search( $value, $this->data );
	}
	/*********************** sorts *************************/
	function merge( $data ) {
		if ( is_array( $data ) ) {
			$this->data = array_merge( $this->data, $data );
		} elseif ( is_object( $data ) && $data instanceof MadData ) {
			$this->data = array_merge( $this->data, $data->getData() );
		}
		return $this;
	}
	function sort() {
		sort( $this->data );
		return $this;
	}
	function ksort() {
		ksort( $this->data  );
		return $this;
	}
	function natsort() {
		natsort( $this->data );
		return $this;
	}
	function kNatsort() {
		$rv = array();
		$keys = array_keys( $this->data );
		natsort( $keys );
		foreach( $keys as $key ) {
			$rv[$key] = $this->data[$key];
		}
		$this->data = $rv;
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
	function getKeys() {
		return new MadData( array_keys($this->data) );
	}
	function getValues() {
		return new MadData( array_values($this->data) );
	}
	function getArrayKeys() {
		return array_keys($this->data);
	}
	function getArrayValues() {
		return array_values($this->data);
	}
	function getDictionary( $target1='', $target2 = '' ) {
		$rv = array();
		foreach( $this->data as $key => $row ) {
			if ( ! empty( $target2 ) ) {
				$rv[$row[$target1]] = $row[$target2];
			} else if ( ! empty( $target1 ) ) {
				$rv[$key] = $row[$target1];
			} else {
				$rv[$key] = current($row);
			}
		}
		return new MadData( $rv );
	}
	function dic( $target1='', $target2 = '' ) {
		return $this->getDictionary( $target1, $target2 );
	}
	function implode( $glue = '' ) {
		return implode( $glue, $this->data );
	}
	function getReverseDictionary( $target ) {
		$rv = array();
		foreach( $this->data as $key => $row ) {
			$rv[$row->$target] = $key;
		}
		return new MadData( $rv );
	}
	function json() {
		return json_encode( $this->getArray() );
	}
	/************* Countable implements ****************/
	function count() {
		return count( $this->data );
	}
	/************* IteratorAggregate implements ****************/
	public function getIterator() {
		return new ArrayIterator( $this->getData() );
	}
	/************* ArrayAcess implements ****************/
	public function first() {
		reset( $this->data  );
		return $this->current();
	}
	public function current() {
		$rv = current( $this->data );
		if ( is_array( $rv ) ) {
			return new MadData( $rv );
		}
		return $rv;
	}
	public function next() {
		return next( $this->data );
	}
	public function offsetUnset($key) {
		unset( $this->$key );
	}
	public function offsetExists($key) {
		return isset( $this->$key );
	}
	public function offsetSet($key, $value) {
		$this->set( $key, $value );
	}
	public function offsetGet($key) {
		if ( ! isset( $this->data[$key] ) ) {
			return '';
		}
		return $this->data[$key];
	}
	public function end() {
		return end( $this->data );
	}
	/******************* magic methods *****************/
	function __get( $key ) {
		return $this->get( $key );
	}
	function __set( $key, $value ) {
		$this->set( $key, $value );
	}
	function __unset($key) {
		if ( isset( $this->data[$key] ) ) {
			unset( $this->data[$key] );
		}
	}
	function has( $key ) {
		if ( isset( $this->data[$key] ) ) {
			return true;
		}
		return false;
	}
	function __isset( $key ) {
		return $this->has( $key );
	}
	function __toString() {
		return '';
	}
	/*********************** test util ***********************/
	// this hen.
	function isArray( &$array ) {
		return (bool)(
				$array instanceof ArrayAccess ||
				$array instanceof Traversable ||
				is_array($array)
				);
	}
	public function isEmpty() {
		return empty( $this->data );
	}
	function test() {
		return (new MadDebug)->printR( $this->data );
	}
}

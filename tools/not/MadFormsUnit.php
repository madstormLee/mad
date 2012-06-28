<?
class MadFormsUnit {
	protected $data = array();
	function __construct() {
	}
	function label() {
		return "<label for='$this->id'>$this->label</label>";
	}
	function setData( $data=array() ) {
		$this->data = $data;
	}
	function get() {
		return '';
	}
	function __get( $key ) {
		return ckKey( $key, $this->data );
	}
	function __set( $key, $value ) {
		$this->data[$key] = $value;
	}
	function __toString() {
		return $this->get();
	}
}

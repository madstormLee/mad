<?
class MadNull {
	function isEmpty() {
		return true;
	}
	function in( $value ) {
		return false;
	}
	function addData( $data ) {
	}
	function getData() {
		return $this;
	}
	function __get( $key ) {
		return new self;
	}
	function __toString() {
		return '';
	}
}

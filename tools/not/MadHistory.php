<?
class MadHistory {
	function __construct(){
		$this->sess = new MadSession( __class__ );
	}
	function push( $address ) {
		$this->sess->add( $address );
	}
	function pop() {
	}
	function getBefore() {
	}
	function test() {
		$this->sess->test();
	}
}

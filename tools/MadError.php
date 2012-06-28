<?
class MadError {
	private static $instance;

	private function __construct() {
	}
	function getInstance() {
		if ( ! self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}
	function __set( $key, $value ) {
	}
}

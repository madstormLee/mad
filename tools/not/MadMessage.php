<?
class MadMessage {
	private static $instance;
	const UNDEFINED_ERROR = 0;

	private function __construct() {
	}
	function getInstance() {
		if ( ! self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}
	function __get( $key ) {
	}
	function __call( $func, $args ) {
		if ( isset( $this->$func ) ) {
			return new MadMessageCode( $this->$func );
		}
		return self::UNDEFINED_ERROR;
	}
	function __set( $key, $value ) {
	}
}

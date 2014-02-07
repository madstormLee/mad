<?
class MadGlobal {
	private static $instance;
	private $data;

	private function __construct() {
		$this->data = &$GLOBALS;
	}
	public static function getInstance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self;
		}
		return self::$instance;
	}
	function __get( $key ) {
		if ( isset( $this->data[$key] ) ) {
			return $this->data[$key];
		}
		return '';
	}
	function __set( $key, $value ) {
		$this->data[$key] = $value;
	}
	function test() {
		(new MadDebug)->printR( $this->data );
	}
}

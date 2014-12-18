<?
class MadGlobal {
	private static $instance;
	private $data;

	private function __construct() {
		$this->data = &$GLOBALS;
	}
	public static function getInstance() {
		self::$instance || self::$instance = new self;
		return self::$instance;
	}
	function test() {
		printR( $this->data );
	}
}

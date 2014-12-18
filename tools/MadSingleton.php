<?
class MadSingleton {
	private static $instance = null;

	protected function __construct() {
	}
	public static function getInstance() {
		if ( ! self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}
}

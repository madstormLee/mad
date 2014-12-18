<?
class MadSingletonData extends MadAbstractData {
	private static $instance = null;

	protected function __construct() {
	}
	/* for Singleton pattern this method must implement */
	public static function getInstance() {
		if ( ! self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}
}

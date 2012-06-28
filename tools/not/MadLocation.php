<?
class MadLocation {
	static $instance;
	private $data;
	public $back;
	function __construct() {
		if ( ! $this->back = ckKey( 'HTTP_REFERER', $_SERVER ) ) {
			$this->back = '/';
		}
	}
	function getInstance() {
		if ( ! self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}
	function __get( $key ) {
	}
}

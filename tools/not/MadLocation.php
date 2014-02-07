<?
class MadLocation {
	static $instance;
	private $data;

	function __construct() {
		$server = MadParams::create('_SERVER');
		if ( ! $this->back = $server->HTTP_REFERER ) {
			$this->back = '/';
		}
	}
	function getInstance() {
		if ( ! self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}
}

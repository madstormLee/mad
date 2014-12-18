<?
class MadPath extends MadAbstractData {
	private static $instance;

	private function __construct() {
		$server = MadParams::create('server');
		$this->root = realPath( $server->DOCUMENT_ROOT );
		$this->madtools = dirName(__file__);
		$this->mad = realPath( $this->tools . '/..';
		$this->project= dirName( $this->root . $server->SCRIPT_NAME );
	}
	public static function getInstance() {
		if ( ! self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}
}

<?
class Log {
	private static $instance;
	private $sess;

	private function __construct() {
		$this->sess = new MadSession(__class__);
	}
	public function getInstance() {
		if ( ! self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}
	function isLogin() {
		return true;
	}
	function isRoot() {
		return $this->sess->root;
	}
}

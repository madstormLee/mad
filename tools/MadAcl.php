<?
class MadAcl {
	private static $instance;

	private function __construct() {
	}
	function getInstance() {
		if ( ! self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}
	function check() {
		if ( empty( $this->get->no ) ) {
			return $this->getMessageCode('illegalAccess');
		}
	}
}


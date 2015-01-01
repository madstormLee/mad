<?
class MadSessionUser {
	private static $instance;
	private $data = null;

	private function __construct() {
		if ( isset( $_SESSION['user'] ) ) {
			$this->data = &$_SESSION['user'];
		} else {
			$this->logout();
		}
	}
	public static function getInstance() {
		self::$instance || self::$instance = new self;
		return self::$instance;
	}
	function getCodeNumber() {
		return $_SESSION['_CodeNumber'];
	}
	function getLevel() {
		return $this->groupId;
	}
	function checkIp() {
		$ipCheck = new IpCheck;
		if (! $ipCheck->isAdmin("")) {
			throw new Exception( '허가되지 않은 접근 아이피입니다.' );
		}
		return true;
	}
	function checkAuth() {
		if ( ! $this->hasAuth( $info->level ) ) {
			throw new Exception('권한이 부족합니다.');;
		}
	}
	function isAdmin() {
		return $this->getLevel() == 1;
	}
	function hasAuth( $groupId = 0 ) {

		return $this->getLevel() <= $groupId ;
	}
	function regist( $user ) {
		$_SESSION['user'] = $user;
		$this->data = &$_SESSION['user'];
		return $this;
	}
	function logout() {
		$this->regist( array( 'level' => 1000 ) );
		return true;
	}
	function __get( $key ) {
		if ( isset( $this->data[$key] ) ) {
			return $this->data[$key];
		}
		return false;
	}
}


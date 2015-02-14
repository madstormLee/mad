<?
class MadSessionUser {
	private static $instance;
	public static function getInstance() {
		self::$instance || self::$instance = new self;
		return self::$instance;
	}

	protected $user = null;

	protected function __construct() {
		if ( isset( $_SESSION['user'] ) ) {
			$this->user = &$_SESSION['user'];
		} else {
			$this->logout();
		}
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
	function isLogin() {
		return $this->user->getLevel() <= $this->user->getLevel('member');
	}
	function isAdmin() {
		return $this->user->getLevel() == 1;
	}
	function hasAuth( $level = 0 ) {
		return $this->user->getLevel() <= $level ;
	}
	function login( MadUser $user ) {
		$_SESSION['user'] = $user;
		$this->user = &$_SESSION['user'];
		return $this;
	}
	function logout() {
		$this->login( new MadUser );
		return true;
	}
	function getUser() {
		return $this->user;
	}
	function __set( $key, $value ) {
		throw new Exception( 'No Access to ' . $key );
	}
	function __get( $key ) {
		return $this->user->$key;
	}
}


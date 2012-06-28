<?
class MadLog {
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
		return ! ( ! $this->sess->root );
	}
	function loginRoot( $id, $pw ) {
		$info = new MadIni('ini/rootInfo');
		if ( $info->login->id === sha1($id) &&
			$info->login->pw === sha1($pw) ) {
			$info->lastLog = array(
					'ip' => $_SERVER['REMOTE_ADDR'],
					'inTime' => date('Y-m-d h:i:s', $_SERVER['REQUEST_TIME']),
					'outTime' => date('Y-m-d h:i:s', $_SERVER['REQUEST_TIME']),
					'count' => ++$info->lastLog->count,
					);
			$info->save();
			$this->sess->root = $info;
			return true;
		}
		return false;
	}
	function logoutRoot() {
		$info = new MadIni('ini/rootInfo');
		$info->lastLog->outTime = date('Y-m-d h:i:s', $_SERVER['REQUEST_TIME']);
		$info->save();
		unset( $this->sess->root );
	}
}

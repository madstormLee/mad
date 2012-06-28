<?
class MadLog {
	private static $instance;
	private $afterLogin = '';
	private $sess;
	private $denyPage = 'back';
	private $agreement = '';
	private $viewsDir;
	private $layout = '';
	private $madArr = array();
	const ROOT = 0;
	const ADMIN = 10;
	const ADVANCED_USER = 100;
	const USER = 200;
	const INSTANT_USER = 255;
	const GUEST_USER = 300;

	private function __construct($tableName) {
		$this->className = __class__;
		$this->table = (empty($tableName)) ? __class__ : __class__.'_'.$tableName;
		$this->sess = new MadSession($this->table);
		$this->setViewsDir(ROOT.'mad/views/MadLog/');
		$this->madArr['className'] = $this->className;
		if ( isset($_POST[$this->className])) {
			$action = $_POST[$this->className].'Action';
			$this->$action();
		}
	}
	public static function getInstance($tableName='') {
		if( self::$instance === null ) {
			self::$instance = new self($tableName);
		}
		return self::$instance;
	}
	private function rootLoginAction() {
		if ( ! $this->isAdmin() ) die;
		$conn = new MadIniManager(MADINI . 'conn.ini');
		$post = new MadData( sqlin($_POST) );
		if ( $post->id === $conn->id
				&& $post->pw === $conn->pw
				&& $post->db === $conn->db ) {
			$this->sess->userLevel = self::ROOT;
			$this->sess->name = 'root';
			$this->sess->id = 'root';
		}
		if ( $this->isROOT() ) {
			move('/mad/');
		}
	}
	private function listAction() {
		$query = "select * from $this->table";
		$q = new Q($query);
		$this->madArr = array(
				'className' => $this->className,
				'pageNavi' => new PageNavi(1,10),
				'registers' => $q->toArray(),
				);
	}
	private function writeAction() {
	}
	private function insAction() {
	}
	function setViewsDir($viewsDir) {
		$this->viewsDir = $viewsDir;
	}
	function isRoot() {
		$rv = ( $this->getUserLevel() <= self::ROOT ) ? true : false;
		return $rv;
	}
	function setDomain($domain) {
		$this->table = __class__ . '_' . $domain;
		if ( ! is_table($this->table) ) {
			$installer = new MadInstaller();
			$installer->install($this->table);
		}
	}
	function limit( $condition, $denyPage='', $denyMessage='' ) {
		if( empty( $denyPage ) ) $denyPage = $this->denyPage ;
		if ( $condition === true ) {
			if( empty( $denyMessage ) ) move($denyPage);
			else alert( $denyMessage, $denyPage );
		}
	}
	function isAdmin() {
		$rv = ( $this->getUserLevel() <= self::ADMIN ) ? true : false;
		return $rv;
	}
	function limitLevel( $level, $denyPage='', $denyMessage='' ) {
		$this->limit( $this->getUserLevel() > $level , $denyPage , $denyMessage );
	}
	function setDenyPage( $denyPage ) {
		$this->denyPage = $denyPage;
	}
	function __get($key) {
		if ( isset($this->sess->$key) ) {
			return $this->sess->$key;
		} else {
			return false;
		}
	}
	function isLogin() {
		return $this->sess->id;
	}
	function getUserId() {
		return $this->sess->id;
	}
	function getUserName() {
		return $this->sess->name;
	}
	function getUserLevel() {
		if ( ! $this->isLogin() ) return self::GUEST_USER;
		return $this->sess->userLevel;
	}
	function setAfterLogin($address) {
		$this->afterLogin = $address;
	}
	function registAgree() {
		$agreement = $this->agreement;
		include $this->views.'registAgree.html';
	}
	function secessionAgree() {
	}
	function socialNoCheck() {
		$form = new MadForm();
		$name = $form->text('name');
		$birthDate = $form->text('birthDate');
		$identityNo = $form->text('identityNo');
		include $this->views.'socialNoCheck.html';
	}
	private function updateCell( $cell ) {
		$rv = false;
		if ( ! $this->isLogin() ) {
			return false;
		}
		if ( strlen($cell) < 9 ) {
			return false;
		}
		$userId = $this->getUserId();
		$query = "update $this->table set cell='$cell' where id='$userId'";
		$q = new Q($query);
		return $q->rows();
	}
	function logout() {
		$this->sess->destroy();
	}
	function loginStatus(){
		if ( ! empty($this->afterLogin) ) {
			replace($this->afterLogin);
		}
		$query = "select id,name,email,messages,last_logged_date,log_counter from {$this->table} where id='{$this->sess->id}'";
		$q = new Q($query);
		extract($q->row());
		$logout = new PostButton('LogOut','logout',$this->program);
		include $this->views.'log_status.html';
	}
	private function findIdAction() {
	}
	private function findPwAction() {
	}
	private function loginAction() {
		extract(sqlin($_POST));
		$query="select id, name, userLevel from $this->table where id='$id' and pw=password('$pw')";
		$q = new Q($query);

		if( $q->rows() < 1 ){
			alert('???Ìµ? È¤Àº ?Ð½????å°¡ ??Ä¡???? ?Ê½À´Ï´?.','back');
			die;
		}
		extract($q->row());

		$this->sess->userLevel = $userLevel;
		$this->sess->id = $id;
		$this->sess->name = $name;
		new Q("update $this->table set last_logged_date=now(), log_counter=log_counter+1 where id='$id'");
	}
	function test() {
		$this->sess->test();
	}
	function limitGroup($group) {
		$this->group = $group;
		if ( ! in_array($user_group, $group) ) {
			$this->denied();
		}
	}
	function getLoginForm() {
		$layout = new Layout('loginForm', $this->viewsDir);
		$layout->className = $this->className;
		return $layout;
	}
	function getStatus() {
		$layout = new Layout('loginStatus', $this->viewsDir);
		return $layout;
	}
	private function denied() {
		replace($this->deny_page);
		die;
	}
	private function setLayout($layout) {
		$this->layout = new Layout($layout,$this->viewsDir);
		$action = $layout.'Action';
		$this->$action();
	}
	private function loginFormAction() {
	}
	function __call($method, $args) {
		alert ( "There is not $method in $this->className.");
		return ;
	}
	function __toString() {
		if ( isset($_GET[$this->className]) ) {
			$layout = $_GET[$this->className];
		} else {
			$layout = 'loginForm';
		}
		$this->setLayout($layout);

		$this->layout->set($this->madArr);
		print $this->layout;
		return '';
	}
	// added
	private function isValidId() {
		return true;
	}
}

<?
class LogController extends Preset {
	function __construct(){
		parent::__construct();
		$this->sess = new MadSession( __class__ );
		if ( ! $this->sess->from ) {
			$this->sess->from = '/mad';
		}
	}
	function indexAction() {
		$file = new MadFile( 'logs' );
		$this->main = nl2br( $file );
	}
	function rootAction() {
		if ( $this->log->isRoot() ) {
			$this->js->replace('back');
		}
		$this->layout->setView( 'views/layouts/basic' );
		return $this->main;
	}
	function adminAction() {
		if ( $this->log->getUserLevel() < 10 ) {
			move ( '/admin' );
		}
	}
	function loginRootAction() {
		$post = $this->post;
		$this->log->loginRoot( $post->id, $post->pw );
		if ( $this->log->isRoot() ) {
			$this->js->replace( $this->sess->from );
		}
		$this->js->alert('로그인 정보에 문제가 있습니다.')->replaceBack();
	}
	function logoutRootAction() {
		$this->log->logoutRoot();
		$this->js->replace( 'root' );
	}
	function logoutAction() {
		$this->log->logout();
	}
	public function isIdAction() { 
		if ( ! isset($_POST['id']) ) {
			print 'illigal appoach';
			die;
		}
		$rv = '-1';
		$id = $_POST['id'];
		$table = 'MadLog_user';
		$query = "select count(*) as cnt from $table where id like '$id' limit 1";
		$q = new Q($query);
		$rv = $q->getFirst();
		if ( IS_AJAX ) {
			$this->main = $rv;
		}
	}
	public function isEmailAction() {
		if ( ! isset($_POST['email']) ) {
			print 'illigal appoach';
			die;
		}
		$rv = '-1';
		if ( isset($_POST['email']) ) {
			$email = $_POST['email'];
			if ( IS_AJAX ) {
				$validate = $this->log->simpleValidateEmail($email);
			} else {
				$validate = $this->log->validateEmail($email);
			}
			if ( $validate ) {
				$query = "select count(*) as cnt from MadLog_user where email like '$email' limit 1";
				$q = new Q($query);
				$rv =  $q->getFirst();
			}
		}
		if ( IS_AJAX ) {
			print $rv;
		} else {
			return $rv;
		}
		die;
	}
}

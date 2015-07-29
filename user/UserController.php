<?
class UserController extends MadController {
	function init() {
		parent::init();
		if ( ! strpos($this->router->backUrl, 'user' ) ) {
			$this->session->after = $this->router->backUrl;
		}
		$query = new MadQuery('User');
		if ( ! $query->isTable() ) {
			$this->installAction();
		}
	}
	function indexAction() {
		$get = $this->params;
		$model = $this->model;

		if ( $get->level ) {
			$model->setFindLevel( "=$get->level" );
		}
	}
	function viewAction() {
	}
	function writeAction() {
		$this->model->fetch( $this->params->id );
	}
	function saveAction() {
		return $this->model->setData( $this->params )->save();
	}
	function deleteAction() {
		return $this->model->delete( $this->get->id );
	}
	function signupAction() {
	}
	function saveSignupAction() {
		$post = $this->params;
		$model = $this->model;

		if ( $model->idExists( $post->userid ) ) {
			throw new Exception('이미 사용중인 아이디입니다.');
		}
		$post->level = 100;
		$post->pw = md5( $post->pw );

		$model->setData( $post )->save();
		$this->js->alert('가입 승인이 요청되었습니다.')->replace('./login');
	}
	function signoffAction() {
	}
	function loginAction() {
	}
	function registSessionAction() {
		$post = $this->params;
		$model = $this->model;

		$model->fetchLogin( $post->userId, $post->userPw );

		$this->session->user = $model;
		$this->js->replace( $this->router->project . '/' );
	}
	function logoutAction() {
		unset( MadSession::getInstance()->user );
		$this->js->replace( $this->session->after );
		return 'session user logout';
	}
	function findIdAction() {
	}
	function findPwAction() {
	}
	function historyAction() {
	}
	function addRoleAction() {
		$post = $this->post;
		$log = $this->log->login( $post );
		$this->js->alert( "you logged in as $log->label" )->replace('~/');
	}
	function isIdAction() {
		$post = $this->params;
		if ( ! $post->id ) {
			throw new Exception( 'illigal appoach' );
		}
		return ! ! $this->query->count("userid like '$post->id'");
	}
	function isEmailAction() {
		$post = $this->params;

		if ( ! $post->email ) {
			return 'illigal appoach';
		}
		$rv = '-1';
		if ( IS_AJAX ) {
			$validate = $this->log->simpleValidateEmail($post->email);
		} else {
			$validate = $this->log->validateEmail($post->email);
		}
		if ( ! $validate ) {
			return false;
		}
		$query = "select count(*) as cnt from MadLog_user where email like '$post->email' limit 1";
		$q = new Q($query);
		$rv =  $q->getFirst();
		return $rv;
	}
	// from Persona
	function personaAction() {
		$this->persona = MadPersona::getInstance();
		$get = $this->get;
		if ( $get->projectId ) {
			$this->persona->setProject( $get->projectId );
		}
		if ( ! $this->persona->isProject() ) {
			$this->js->replace( '~/user/login' );
		}
		$referer = $server->HTTP_REFERER;
		if( $referer && ! preg_match('!px/persona!i', $referer) ) {
			$_SESSION['referer'] = $referer;
		}


		if ( $project = $this->session->currentProject ) {
			$index = new MadJson( "projects/$project/persona.json" );
		} else {
			$index = new MadData;
		}
		$this->view->index = $index;
	}
	function personaRegistSessionAction() {
		$this->persona->isProject();
		$persona = MadPersona::getInstance()->login( $this->post );

		if( isset( $_SESSION['referer'] ) ) {
			$referer = $_SESSION['referer'];
			unset( $_SESSION['referer'] );
		} else {
			$referer = '/' . $this->persona->getProject();
		}

		$this->js->alert( "you logged in as " . $this->persona->label )->replace( $referer );
	}

}

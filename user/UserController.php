<?
class UserController extends MadController {
	function indexAction() {
	}
	function viewAction() {
	}
	function writeAction() {
	}
	function saveAction() {
		return $model->setData( $this->params )->save();
	}
	function deleteAction() {
		return $model->delete();
	}
	function loginAction() {
		$this->layout->setView('views/layouts/mainOnly.html');
	}
	function logoutAction() {
		return $this->userLog->logout();
	}
	function addRoleAction() {
		$post = $this->post;
		$log = $this->log->login( $post );
		$this->js->alert( "you logged in as $log->label" )->replace('~/');
	}
	function setAction() {
		$user = new User( $this->params->id );

		if ( ! $user->id ) {
			return 'No user' ;
		}
		if( $user->password != sha1( $this->params->password ) ) {
			return 'No matching password' ;
		}

		$_SESSION['User'] = $user;
		return 'logged in ' . $user->id;
	}
	function isIdAction() { 
		$post = $this->params;
		if ( ! $post->id ) {
			return 'illigal appoach';
		}
		$query = "select count(*) as cnt from MadLog_user where id like '$post->id' limit 1";
		$q = new Q($query);
		return $q->getFirst();
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
			$list = new MadJson( "projects/$project/persona.json" );
		} else {
			$list = new MadData;
		}
		$this->main->list = $list;
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

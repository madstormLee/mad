<?
class PersonaController extends MadController {
	function __construct() {
		parent::__construct();
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
	}
	function indexAction() {
		if ( $project = $this->session->currentProject ) {
			$list = new MadJson( "projects/$project/persona.json" );
		} else {
			$list = new MadData;
		}
		$this->main->list = $list;
	}
	function writeAction() {
	}
	function loginAction() {
		$this->layout->setView('views/layouts/mainOnly.html');
		$this->css->clear()->add("~/css/$this->controllerName/login.css");
	}
	function editAction() {
	}
	function configAction() {
		$config = new StoreConfig( $this->log->getId() ) ;
		$this->main->yesNo = array( 1 => 'yes', 0 => 'no' );
		$this->main->model = $config;
		$this->header->subNavi = new MadView('views/Custom/subNavi.html');
	}
	function logoutAction() {
		$this->log->logout();
		$this->js->replace('./login');
	}
	function registSessionAction() {
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
	function saveConfigAction() {
		printR( $this->post );
	}
}

<?
class UserController extends MadController {
	function indexAction() {
	}
	function loginAction() {
		print sha1('jtyejbsjfzmv');
		if ( $this->log->isLogin() ) {
			//todo you must check that is backUrl UserController or not
			$this->js->replaceBack();
		}
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
		$this->js->replaceBack();
	}
	function registSessionAction() {
		$post = $this->post;
		$log = $this->log->login( $post );
		$this->js->alert( "you logged in as $log->label" )->replace('~/');
	}
	function saveConfigAction() {
		printR( $this->post );
	}
}


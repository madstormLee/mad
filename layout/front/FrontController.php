<?
class FrontController extends MadController {
	function indexAction() {
		$view = $this->view;

		$view->title = $this->config->title;
		$view->js = MadJs::getInstance();
		$view->js->addFirst('./jquery-1.8.3.min.js');
		$view->css = MadCss::getInstance();

		// views
		$left = MadController::create('FileView');
		$view->left = $left->getContents();
		$view->header = MadController::create('Menubar');

		$router = MadRouter::getInstance();
		$view->router = $router;

		if ( $router->component == $this->name ) {
			$main = new MadController;
		} else {
			$main = MadController::create( $router->component );
		}
		$main->setAction( $router->action );

		if ( $router->action == 'save' ) {
			$journal = MadController::create('Journal');
			$data = new MadData( array(
				"contents" => "$router->component/$router->action 이 실행 됨.",
			));
			$journal->post = $data;
			$journal->setAction( 'save' );
			$journal->getContents();
		}
		$view->main = $main->getContents();

		$view->setProjectRoot( $router->projectRoot );
	}
}

<?
class LayoutController extends MadController {
	function indexAction() {
	}
	function layoutAction() {
		$router = MadRouter::getInstance();

		$component = new MadComponent( $router->component );
		$params = new MadParams($router->method);
		$main = $component->{$router->method}( $router->action, $params );

		if ( $router->ajax ) {
			return $router->urlAdjustTag( $main );
		}

		$this->view->main = $main;
		$this->view->right = new MadView('Layout/right.html');
		return $router->urlAdjustTag( $this->view );
	}
	function defaultAction() {
		$router = MadRouter::getInstance();

		$component = new MadComponent( $router->component );
		$params = new MadParams($router->method);
		$main = $component->getContents( $router->action, $params, $router->method );

		if ( $router->ajax ) {
			return $router->urlAdjustTag( $main );
		}

		$this->view->main = $main;
		return $router->urlAdjustTag( $this->view );
	}
	function menuBarAction() {
		$view = $this->view;

		$sitemap = new MadJson('sitemap.json');
		if ( ! $sitemap->isFile() ) {
			$sitemap = new MadComponentList(PROJECT_ROOT);
		}
		$view->sitemap = $sitemap;

		$userLog = MadUserLog::getInstance();
		$this->view->userLog = $userLog;
	}
}

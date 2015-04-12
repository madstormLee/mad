<?
class ControllerController extends MadController {
	function indexAction() {
		$this->view->controllers = new Controller( 'controllers' );
	}
	function actionsAction() {
		$controllerName = $this->params->id . 'Controller';
		include_once $this->project->getRoot() . "controllers/$controllerName.php";
		$controller = new $controllerName;
		$actions = $controller->getActions();
		$rv = '<dd><ul>';
		foreach( $actions as $action ) {
			$rv .= "<li><a href='#action'>$action</a></li>";
		}
		$rv .= '</ul></dd>';
	}
	function getActionsAction() {
		$controllerName = $this->params->id . 'Controller';
		$file = "controllers/$controllerName.php";
		include_once $file;
		$controller = new $controllerName;
		$actions = $controller->getActions();
		$rv = '<ul>';
		foreach( $actions as $action ) {
			$rv .= "<li><a href='#action'>$action</a></li>";
		}
		$rv .= '</ul>';
	}
}

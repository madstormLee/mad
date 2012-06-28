<?
class ControllerController extends Preset {
	function listAction() {
		$this->main->controllers = new Controllers( $this->project->getRoot() . 'controllers' );
		return $this->main;
	}
	function actionListAction() {
		$controllerName = $this->get->controller . 'Controller';
		include_once $this->project->getRoot() . "controllers/$controllerName.php";
		$controller = new $controllerName;
		$actions = $controller->getActions();
		$rv = '<dd><ul>';
		foreach( $actions as $action ) {
			$rv .= "<li><a href='#action'>$action</a></li>";
		}
		$rv .= '</ul></dd>';
		return $rv;
	}
}

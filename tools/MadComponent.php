<?
class MadComponent {
	private $component = '';
	private $config = '';
	private $action = 'index';

	function __construct( $component ) {
		$this->component = $component;
	}
	function setConfig( $config ) {
		$this->config = $config;
		return $this;
	}
	function setAction($action = 'index') {
		$this->action = $action;
		return $this;
	}
	function setParams( $params ) {
		$this->params = $params;
	}
	function getContents() {
		$modelName = ucFirst( baseName( $this->component ) );
		// controller
		$controllerName = $modelName . 'Controller';
		$controllerFile = $this->component . "/$controllerName.php";
		include_once $controllerFile;
		$controller = new $controllerName;
		$controller->configDir = "$this->component/$this->config";

		// view
		$view = new MadView( "$controller->configDir/$this->action.html" );
		$controller->view = $view;

		// model
		include_once $this->component . "/$modelName.php";
		$model = new $modelName;
		$controller->model = $model;

		$actionName = $this->action . 'Action';
		$controller->$actionName();

		return $view;
	}
}

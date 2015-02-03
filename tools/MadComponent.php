<?
class MadComponent {
	private $component = 'index';
	private $action = 'index';

	private $config = '';
	private $params = null;

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
	function createController() {
		$modelName = ucFirst( baseName( $this->component ) );
		$controllerName = $modelName . 'Controller';
		$controllerFile = $this->component . "/$controllerName.php";
		if ( ! is_file( $controllerFile ) ) {
			return new MadController;
		}
		include_once $controllerFile;
		$controller = new $controllerName;
		return $controller;
	}
	function createModel() {
		$modelName = ucFirst( baseName( $this->component ) );
		$modelFile = $this->component . "/$modelName.php";
		if ( ! is_file( $modelFile ) ) {
			return new MadModel;
		}
		include_once $modelFile;
		$model = new $modelName;
		return $model;
	}
	function getContents() {
		// controller
		$controller = $this->createController();
		$controller->configDir = "$this->component/$this->config";
		$controller->params = $this->params;

		// view
		$view = new MadView( "$controller->configDir/$this->action.html" );
		$controller->view = $view;

		// model
		$model = $this->createModel();
		$controller->model = $model;
		$view->model = $controller->model;

		$result = $controller->action( $this->action );

		return $result;
	}
}

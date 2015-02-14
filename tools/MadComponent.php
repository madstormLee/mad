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
	function createView($controller) {
		if ( empty( $controller->configDir ) ) {
			return new MadView( "$this->action.html" );
		}
		return new MadView( "$controller->configDir/$this->action.html" );
	}
	function getContents() {
		// controller
		$controller = $this->createController();
		if ( empty( $this->component ) ) {
			$controller->configDir = "$this->config";
		} else {
			$controller->configDir = "$this->component/$this->config";
		}
		$controller->params = $this->params;

		MadConfig::getInstance()->addConfig( "$controller->configDir/config.json" );

		// view
		$view = $this->createView( $controller );
		$controller->view = $view;

		// model
		$model = $this->createModel();
		$controller->model = $model;
		$view->model = $controller->model;

		$result = $controller->action( $this->action );

		return $result;
	}
	function __toString() {
		try {
			$rv = (string) $this->getContents();
		} catch( Exception $e ) {
			$rv = $e->getMessage();
		}
		return $rv;
	}
}

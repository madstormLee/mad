<?
class MadComponent {
	private $dir = '';
	private $component = 'Index';
	private $action = 'index';

	function __construct( $component = 'Index') {
		if ( strpos( $component, '/' ) ) {
			$pathExploded = explode( '/', $component );
			$component = array_pop( $pathExploded );
			$this->dir = implode( $pathExploded );
			if ( empty( $this->dir ) ) {
				$this->dir = '/';
			}
		}
		$this->component = $component;
	}
	static function isComponent( $name ) {
		return is_dir( $name );
	}
	function getController() {
		$name = $this->component.'Controller';
		$file = "$this->dir$this->component/$name.php";
		if ( is_file( $file ) ) {
			include $file;
			return new $name;
		}
		return new MadController;
	}
	function getView( $action = 'index' ) {
		print "$this->dir$this->component/$action.html";
		return new MadView( "$this->dir$this->component/$action.html" );
	}
	function getModel() {
		$file = "$this->dir$this->component/$this->component.php";
		if ( ! is_file( $file ) ) {
			return new MadModel;
		}
		include_once $file;
		return new $this->component;
	}
	function get( $action='index' , $params = null ) {
		$controller = $this->getController();
		$view = $this->getView( $action );
		$model = $this->getModel();

		$controller->params = $params;
		$controller->view = $view;
		$controller->model = $model;
		$controller->config = MadConfig::getInstance();
		$controller->css = MadCss::getInstance()->addExists( "~/$this->component/style.css" );
		$controller->js = MadJs::getInstance()->addExists( "~/$this->component/script.js" );

		$view->setData( $controller->getData() );
		$view->controller = $controller;

		if ( $result = $controller->{$action . 'Action'}() ) {
			return $result;
		}
		return $view;
	}
	function getConfig() {
		return new MadJson( "$this->component/config.json" );
	}
	function post( $action, $params = null ) {
		$controller = $this->getController();
		$controller->params = $params;
		$controller->model = $this->getModel();
		$action = $action . 'Action';
		return $controller->$action();
	}
	function getContents( $action='index', $params=null, $method='GET' ) {
		if( $method == 'POST' ) {
			return $this->post( $action, $params );
		}
		return $this->get( $action, $params );
	}
	function __toString() {
		try {
			return (string) $this->getContents();
		} catch( Exception $e ) {
			return $e->getMessage();
		}
	}
}

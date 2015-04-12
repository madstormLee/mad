<?
class MadController {
	protected $name = 'Mad';
	protected $data = array();

	function __construct( $component='', $params = null ) {
		$explodeComponent = explode( '/', $component );
		$action = array_pop( $explodeComponent );
		$component = implode('/', $explodeComponent);

		$this->name = subStr( get_class($this), 0, -10 );
		$this->request = "$component/$action";
		$this->component = $component;
		$this->action = $action;

		if ( null === $params ) {
			$this->params = MadRouter::getInstance()->params;
		} else {
			$this->params = $params;
		}

		$this->init();
	}
	public static function create( $component, $params = null ) {
		$baseDir = dirname( $component );
		$name = ucFirst( baseName( $baseDir ) );
		if ( $name == '.' ) {
			$name = '';
		}
		$controllerName = $name . 'Controller';
		
		if ( is_file( $file = "$baseDir/$controllerName.php" ) ) {
			include_once $file;
			return new $controllerName($component, $params);
		}
		return new self($component, $params);
	}
	public static function front() {
		try {
			$router = MadRouter::getInstance();
			return MadController::create( $router->componentPath );
		} catch ( Exception $e ) {
			return $e->getMessage();
		}
	}
	function init() {
		$this->config = MadConfig::getInstance();
		$this->config->addConfig( "$this->component/config.json" );

		$this->addData( $this->config->getData() );

		$this->view = new MadView( "$this->component/$this->action.html" );
		$this->model = $this->createModel();
		$this->view->model = $this->model;
		$this->info->subtitle = $this->name;
	}
	function createModel( $modelName='' ) {
		if ( empty($modelName) ) {
			$modelName = ucFirst( baseName( $this->component ) );
		}
		$file = $this->component . "/$modelName.php";
		if ( is_file( $file ) ) {
			include_once $file;
			return new $modelName;
		}
		return new MadModel;
	}
	function setData( $data ) {
		$this->data = $data;
		return $this;
	}
	function addData( $data ) {
		foreach( $data as $key => $row ) {
			$this->data[$key] = $row;
		}
		return $this;
	}
	function getData() {
		return $this->data;
	}
	function getActions() {
		$methods = preg_grep( '/Action$/', get_class_methods( $this ) );
		$actions = new MadData( $methods );
		$actions->walk( function( &$value ) {
			$value = subStr( $value, 0, -6 );
		});
		return $actions;
	}
	/*************** magic methods *******************/
	function __set( $key, $value ) {
		$this->data[$key] = $value;
	}
	function __get( $key ) {
		return isset( $this->data[$key] ) ? $this->data[$key]:false;
	}
	function __isset( $key ) {
		return isset( $this->data[$key] );
	}
	function __call( $action, $args ) {
		return null;
	}
	function __toString() {
		MadHeaders::utf8();

		$action = trim($this->action);
		if ( empty($action) ) {
			throw new BadMethodCallException;
		}
		$actionName = $action . 'Action';
		$result = $this->$actionName();

		if ( $result === null && ! $this->view->isFile() ) {
			http_response_code(404);
			$this->view->setFile('mad/layout/404.html');
		}

		if ( null === $result ) {
			$result = $this->view;
		}

		if( $this->router->ajax || ! isset( $this->layout ) ) {
			return (string)$result;
		}
		$layout = $this->layout;
		$layout->main = $result;
		return (string)$layout;
	}
}

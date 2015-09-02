<?
class MadController {
	protected $name = 'Mad';
	protected $data = array();

	public static function front() {
		try {
			return self::create();
		} catch ( PDOException $e ) {
			return printR($e, true);
		} catch ( Exception $e ) {
			return $e->getMessage();
		}
	}
	public static function create( $component='', $params = null ) {
		MadConfig::getInstance();
		if ( empty( $component ) ) {
			$component = MadRouter::getInstance()->getComponentPath();
		}
		$baseDir = dirname( $component );
		$name = ucFirst( baseName( $baseDir ) );
		if ( $name == '.' ) {
			$name = '';
		}
		$controllerName = $name . 'Controller';
		
		$file = "$baseDir/$controllerName.php";
		if ( is_file( $file  ) ) {
			include_once $file;
			return new $controllerName($component, $params);
		}
		return new self($component, $params);
	}
	function __construct( $component='', $params = null ) {
		$explodeComponent = explode( '/', $component );
		$action = array_pop( $explodeComponent );
		$component = implode('/', $explodeComponent);

		$this->component = $component;
		$this->action = $action;

		if ( null === $params ) {
			$this->params = MadRouter::getInstance()->params;
		} else {
			$this->params = $params;
		}

		$this->config = MadConfig::getInstance();
		$this->config->addConfig( "$this->component/config.json" );

		$this->addData( $this->config->getData() );

		$this->view = new MadView( "$this->component/$this->action.html" );
		$this->model = $this->createModel();
		$this->view->model = $this->model;
		$this->view->params = $this->params;
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
		$actions = new MadData( preg_grep( '/Action$/', get_class_methods( $this ) ) );
		return $actions->walk( function( &$value ) { $value = subStr( $value, 0, -6 ); });
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
		if ( ! $this->view->isFile() ) {
			throw new BadMethodCallException("$action not found!");
		}
		return null;
	}
	private function interpret( $result ) {
		if ( $result == 0 ) {
			$rv = "$this->action failed.";
		} elseif ( $result > 0 ) {
			$rv = "$this->action succeeded.";
		}
		$this->layout->setFile(MAD . '/project/layout/script.html' );
		return $rv;
	}
	private function getResult() {
		$action = trim($this->action) . 'Action';
		$result = $this->$action();

		if ( null === $result ) {
			$result = $this->view;
			if ( ! $result->isFile() ) {
				http_response_code(404);
				$result->setFile( MAD . '/project/layout/404.html' );
			}
		} else {
			$result = $this->interpret( $result );
		}
		return $result;
	}
	function __toString() {
		MadHeaders::utf8();

		try {
			$result = $this->getResult();

			if( $this->router->ajax || ! isset( $this->layout ) ) {
				return (string)$result;
			}
			$this->layout->main = $result;
		} catch( Exception $e ) {
			$this->view->setFile( MAD . '/project/layout/exception.html' );
			$this->view->e = $e;
			$this->layout->main = $this->view;
		}
		return (string)$this->layout;
	}
}

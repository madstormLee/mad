<?
class MadController {
	protected $name = 'Mad';
	protected $data = array();

	function __construct() {
		$this->name = subStr( get_class($this), 0, -10 );
	}
	public static function create( $path = '' ) {
		$name = ucFirst( baseName( $path ) );

		$controllerName = $name . 'Controller';
		$controllerFile = "$path/$controllerName.php";
		if ( ! is_file( $controllerFile ) ) {
			return new self;
		}
		include $controllerFile;
		return new $controllerName;
	}
	function setData( $data ) {
		$this->data = $data;
		return $this;
	}
	function getData() {
		return $this->data;
	}
	function getActions() {
		$methods = get_class_methods( $this );
		$actions = new MadData;
		foreach( $methods as $method ) {
			if( preg_match( '/Action$/', $method ) ) {
				$actions->add( subStr( $method, 0, -6 ) );
			}
		}
		return $actions;
	}
	function action( $action ) {
		$actionName = $action . 'Action';
		$result = $this->$actionName();
		if ( null === $result ) {
			return $this->view;
		}
		return $result;
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
		$actionName = subStr( $action, 0, -6 );
		$file = get_class( $this ) . "/$actionName.php";
		if ( is_file( $file ) ) {
			include $file;
		}
	}
	function __toString() {
		return get_class( $this );
	}
}

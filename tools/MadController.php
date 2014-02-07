<?
class MadController {
	protected $g = null;

	function __construct() {
		$this->g = MadGlobals::getInstance();
	}
	public static final function create( $name ) {
		$componentsDir = 'components';
		$g = MadGlobals::getInstance();
		if ( $g->dirs->components ) {
			$componentsDir = $g->dirs->components;
		}

		$controllerName = $name . 'Controller';
		$controllerFile = "$componentsDir/$name/$controllerName.php";

		if ( is_file( $controllerFile ) ) {
			include_once $controllerFile;
			return new $controllerName;
		}
		return new self;
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
	protected function getNotFoundTarget() {
		if ( ! $this->layout instanceof MadView ) {
			$this->layout = new MadView;
			return 'layout';
		}
		if ( ! $this->main instanceof MadView ) {
			$this->main = new MadView;
		}
		return 'main';
	}
	protected function getNotFoundView() {
		if ( $this->debug ) {
			$view = 'views/NotFound/debugAction.html';
		} else {
			$view = 'views/NotFound/action.html';
		}
		if( is_file( $view ) ) {
			return $view;
		}
		return MAD . $view;
	}
	/*************** magic methods *******************/
	function __set( $key, $value ) {
		$this->g->$key = $value;
	}
	function __get( $key ) {
		return $this->g->$key;
	}
	function __isset( $key ) {
		return isset( $this->g->$key );
	}
	function __call( $method, $args ) {
		$target = $this->getNotFoundTarget();
		$view = $this->$target;

		$view->setView( $this->getNotFoundView() );

		if ( $this->debug ) {
			$view->controller = $this;
		}

		return $view;
	}
	function __toString() {
		if ( IS_AJAX ) {
			return $this->main;
		}
		return $this->layout;
	}
}

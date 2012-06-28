<?
class MadController extends Mad {
	protected $g;
	protected $state = 'index';
	// protected $layout = null;
	protected $arguments = array();

	function __construct() {
		parent::__construct();
		$this->g = MadGlobal::getInstance();
	}
	protected function init() {
	}
	protected function initAjax() {
	}
	protected function initGet() {
	}
	protected function initPost() {
	}
	function getState() {
		return $this->state;
	}
	function setState( $state ) {
		$this->state = $state;
		if ( method_exists( $this, $state . 'Action') ) {
		}
		return $this;
	}
	/*************** layout methods ***************/
	function setLayout( MadView $layout = null ) {
		return $this->layout = $layout;
	}
	function getLayout() {
		return $this->layout;
	}
	protected function isLayout() {
		return ( $this->layout instanceof MadView );
	}
	/*************** utility methods *******************/
	function getActions() {
		$methods = get_class_methods( $this );
		$actions = array();
		foreach( $methods as $method ) {
			if( preg_match( '/Action$/', $method ) ) {
				$actions[] = subStr( $method, 0, -6 );
			}
		}
		return $actions;
	}
	public final function dispatchResult() {
		$this->init();
		if ( IS_AJAX ) {
			$this->initAjax();
		} else if ( empty( $_POST ) ) {
			$this->initGet();
		} else {
			$this->initPost();
		}

		try {
			$actionResult = $this->{$this->state.'Action'}();
		} catch ( Exception $e ) {
			$actionResult = $e->getMessage();
		}

		if ( $this->isLayout() ) {
			$this->layout->mainContent = $actionResult;
			return $this->layout;
		}
		return $actionResult;
	}
	/*************** magic methods *******************/
	function __get( $key ) {
		return $this->g->$key;
	}
	function __set( $key, $value ) {
		$this->g->$key = $value;
	}
	function __isset( $key ) {
		return isset( $this->g->$key );
	}
	function __call( $method, $args ) {
		throw new Exception( "cannot find requested action '$this->actionName'" );
	}
}

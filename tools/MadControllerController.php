<?
// front controller와 조금 틀리다. 아마.
class MadControllerController {
	private $g;
	private $defaultIni;
	private $layoutView = null;
	private $controller = null;
	private $controllerDir = 'controllers/';

	public function __construct() {
		$this->g = MadGlobal::getInstance();
	}
	function setProjectRoot( $projectRoot ) {
		$this->projectRoot = $projectRoot;
		MadAutoload::getInstance()->addDir( ROOT . $projectRoot . 'models/' );
		return $this;
	}
	function setAction( $action ) {
		$this->action = $action;
		return $this;
	}
	function getController() {
		return $this->controller;
	}
	function setController( $controller ) {
		if ( is_string( $controller ) ) {
			include ROOT . $this->projectRoot . "controllers/$controller.php";
			$this->controller = new $controller;
		} elseif ( $controller instanceof MadController ) {
			$this->controller = $controller;
		}
		return $this;
	}
	function processing() {
		$controller = $this->controller;
		$action = $this->action;

		$view = $controller->$action();
		print preg_replace('!(action|background|src|href)=(["\'])~/!i', "$1=$2$this->projectRoot", (string)$view );
	}
	function stormming() {
		try {
			$this->processing();
		} catch( Exception $e ) {
			print $e;
		}
	}
	function getErrorCode() {
	}
	function __get( $key ) {
		return $this->g->$key;
	}
	function __set( $key, $value ) {
		$this->g->$key = $value;
	}
	function __toString() {
		$this->stormming();
		return '';
	}
	function test() {
		printR( $this->g );
	}
}

<?
class MadFront {
	private static $instance;
	private $config;

	private function __construct() {
		$this->config = MadConfig::getInstance();
		MadDebug::getInstance( $this->config->debug );
		MadSession::start( $this->config->session );
	}
	public static function getInstance() {
		self::$instance || self::$instance = new self;
		return self::$instance;
	}
	function getConfig() {
		return $this->config;
	}
	public function getContents() {
		$config = $this->config;

		$router = MadRouter::getInstance();

		if ( MadComponent::isComponent( $router->component ) ) {
			$component = new MadComponent( $router->component );
		} else {
			$component = new MadComponent( $config->defaultComponent );
		}

		$params = new MadParams("_$router->method");
		$main = $component->{$router->method}( $router->action, $params );

		if ( $router->ajax || $router->method == 'POST' ) {
			return (string) $main;
		}

		if ( ! $config->layout ) {
			return (string) $main;
		}
		$config->main = $main;
		return (string) $config->layout;
	}
	function __toString() {
		return $this->getContents();
	}
}

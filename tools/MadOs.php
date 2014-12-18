<?
class MadOs {
	private static $instance;
	private $config;

	private function __construct() {
		$this->config = $config = MadConfig::getInstance();
		MadDebug::getInstance( $config->debug );
		MadSession::start( $config->session );
	}
	public static function getInstance() {
		self::$instance || self::$instance = new self;
		return self::$instance;
	}
	private function dispatch() {
		$router = MadRouter::getInstance();

		$component = new MadComponent( $router->component );
		$params = new MadParams("_$router->method");
		$rv = $component->{$router->method}( $router->action, $params );

		return $router->urlAdjustTag( $rv );
	}
	function __toString() {
		try {
			$result = $this->dispatch();
			return $result;
		} catch ( PDOException $e ) {
			if ( $this->config->debug == true ) {
				return printR( $e, true );
			}
			throw $e;
		} catch ( Exception $e ) {
			$message = $e->getMessage();
			return $message;
		}
	}
}

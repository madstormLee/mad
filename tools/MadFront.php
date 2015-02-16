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
	public static function sitemapRoute() {
		$sitemap = new MadSitemap('sitemap.json');
		$sitemap->setCurrent();
		$router = $sitemap->getCurrent();

		$params = new MadParams('_GET');
		if ( isset( $router->params ) ) {
			$params->addData( (array) $router->params );
		}

		return self::commonDo( $router, $params );
	}
	public static function temp() {
		error_reporting(E_ALL);
		MadHeaders::utf8();
		MadSession::start();

		$config = MadConfig::getInstance();

		$router = MadRouter::getInstance();
		$params = new MadParams("_$router->method");

		return self::commonDo( $router, $params );

	}
	public static function commonDo( $router, $params ) {
		$config = MadConfig::getInstance();

		// todo: sessionUser exception
		if( isset( $config->auth ) && isset( $config->sessionUser )  ) {
			$result = $config->sessionUser->hasAuth( $config->auth->level );
			if ( ! $result ) {
				if ( $config->auth->component != $router->component ) {
					header( "Location: $router->project/{$config->auth->component}/login" );
				}
			}
		}

		if ( ! is_dir( $router->component ) && isset($config->defaultComponent) ) {
			$router->component = $config->defaultComponent;
		}
		$component = new MadComponent( $router->component );
		$component->setAction( $router->action );
		$component->setParams( $params );
		$main = $component->getContents();

		return self::getLayout( $main );
	}
	public static function getLayout( $main ) {
		$config = MadConfig::getInstance();
		if( $config->router->ajax || (! isset( $config->layout )) ) {
			return $main;
		}
		$component = new MadComponent($config->layout->component);
		$component->setAction($config->layout->action);
		$layout = $component->getContents();
		$layout->main = $main;

		return $layout;
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

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
	public static function temp() {
		error_reporting(E_ALL);
		MadHeaders::utf8();

		$router = MadRouter::getInstance();

		// sitemap section
		$sitemapFile = 'sitemap.json';
		if ( is_file( $sitemapFile ) ) {
			$sitemap = new MadSitemap($sitemapFile);
			$sitemap->setCurrent();
			$current = $sitemap->getCurrent();
		} else {
			$current = $router;
		}

		// component
		$params = new MadParams('_GET');
		if ( isset( $current->params ) ) {
			$params->addData( (array) $current->params );
		}

		$component = new MadComponent( $current->component );
		$component->setAction( $current->action );
		$component->setParams( $params );
		$view = $component->getContents();

		// layout
		$config = new MadJson('config.json'); // temporally

		if( ! isset( $config->layout ) ) {
			return $view;
		}

		$layout = $config->layout;
		$component = new MadComponent($layout->component);
		$component->setAction($layout->action);
		$layout = $component->getContents();

		$layout->main = $view;

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

<?
// setting을 따로 만들어 외부에서 온 내용을 담아두고,
// 실행시에 config 파일을 읽은 후 setting을 덮어쓴다.
class MadFront {
	private static $instance;
	private $g;

	protected function __construct() {
		$this->g = MadGlobal::getInstance();
	}
	public static function getInstance() {
		if ( ! self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}
	private function initConfig() {
		$configFile = "json/configs/front.json";
		if ( is_file( $configFile ) ) {
			$data = array(
				'controller' => $this->controllerName,
				'action' => $this->actionName,
				);
			$config = new MadJson( $configFile , $data );
			if ( $config->objects ) {
				foreach( $config->objects as $key => $value ) {
					$this->$key = new $value;
				}
			}
			if ( $config->instances ) {
				foreach( $config->instances as $key => $init ) {
					// $this->$key = $value::getInstance();
					$this->$key = $init['class']::$init['method']();
				}
			}
			if ( $config->styles ) {
				foreach( $config->styles as $key => $value ) {
					$this->style->add( $value );
				}
			}
			if ( $config->js ) {
				$this->js = MadJs::getInstance();
				foreach( $config->js as $key => $value ) {
					$this->js->add( $value );
				}
			}
			if ( $config->views ) {
				foreach( $config->views as $key => $value ) {
					$this->$key = new MadView( $value );
				}
			}
		}
	}
	private function prepare() {
		// conventionally load configuration
		// PhpStorm load default values for this.
		$phpStorm = new PhpStorm;
		if ( ! $this->config ) {
			$configFile = $phpStorm->files->config;
			if ( is_file( $configFile ) ) {
				$this->config = new MadIni( $configFile );
			} else {
				$this->config = new MadIni( ".phpStorm/$configFile" );
			}
		}
		// make default values if it is not there.
		if ( ! $this->projectRoot ) {
			$this->projectRoot = realpath( ROOT . dirname($_SERVER['SCRIPT_NAME']) ) . DS;
		}
		if ( ! $this->urlRoot ) {
			$this->urlRoot = dirname( $_SERVER['SCRIPT_NAME'] ) . DS;
		}
		$sitemap = new MadSitemap;
		$map = MadUrlMapper::getInstance( $sitemap );
		$this->controllerName = $map->getController();
		$this->actionName = $map->getAction();

		if ( $phpStorm->config->scaffold == 'auto' ) {
			$phpStorm->scaffolding( $this->controllerName, $this->actionName );
		}
	}
	public function excute() {
		$this->get = new MadData( sqlin($_GET) );
		$this->post = new MadData( sqlin($_POST) );

		$this->prepare();
		$this->initConfig();

		$controllerName = $this->controllerName . 'Controller';
		$controller = $this->createController( $controllerName );

		$controller->setState( $this->actionName );
		$rv = $controller->dispatchResult();
		$rv = preg_replace('!(action|background|src|href)=(["\'])~/!i', "$1=$2$this->urlRoot", (string)$rv );
		$rv = preg_replace('!(action|background|src|href)=(["\'])\./!i', "$1=$2$this->urlRoot$this->controllerName/", (string)$rv );
		print $rv;
	}
	private function createController( $controllerName ) {
		$dirs = $this->config->dirs;
		$controllerFile = $dirs->controllers . $controllerName . '.php';
		if( is_file( $controllerFile) ) {
			require_once( $controllerFile );
			return new $controllerName;
		} else if ( class_exists( $controllerName ) ) {
			return new $controllerName;
		} else if ( class_exists( $this->errorController ) ) {
			return new $this->errorController;
		}
		return new MadErrorController;
	}
	// start front
	function stormming() {
		try {
			$this->excute();
		} catch( Exception $e ) {
			print $e;
		}
	}
	function start() {
		return $this->stormming();
	}
	function __toString() {
		$this->stormming();
		return '';
	}
	// setters and getters
	function __get( $key ) {
		return $this->g->$key;
	}
	function __set( $key, $value ) {
		$this->g->$key = $value;
	}
	public function setConfig( $file ) {
		$this->config = new MadIni( $file );
	}
	public function setAction( $actionName ) {
		$this->actionName = array_shift(explode('.', $actionName));
	}
	public function getController() {
		if ( ! $this->controller instanceof MadController ) {
			$this->setController();
		}
		return $this->controller;
	}
	public function setController( MadController $controller = null ) {
		if ( $controller instanceof MadController ) {
			$this->controller = $controller;
		}
		$urlMapper = MadUrlMapper::getInstance();
		$this->controller = new $this->controllerName;
		return $this;
	}
	function test() {
		printR( $this->g );
	}
}

<?
class MadComponent {
	private $dir;

	function __construct( $dir ) {
		$this->dir = $dir;
	}
	public static final function start( $dir = '.' ) {
		try {
			print self::create();
		} catch( Exception $e ) {
			print $e;
		}
	}
	public static final function create( $dir = '.' ) {
		if ( ! is_dir( $dir ) ) {
			throw new Exception( 'no component' );
		}
		return new self( $dir );
	}
	function initFromConfig( $dir ) {
		if ( $config->views ) {
			$globals = MadGlobals::getInstance();
			foreach( $config->views as $key => $file ) {
				$globals->$key = new MadView( "$dir/$file" );
			}
		}
		return $config;
	}
	function getContents() {
		$rv = '';
		$debug = new MadDebug; // for test

		$config = new MadConfig( $this->dir . '/config.json' );

		// $router = MadRouter::getInstance();
		// 1. default
		if ( $config->type == 'php' ) {
			if ( ! is_file( "$this->dir/$router->action.php" ) ) {
				throw new Exception('Cannot found controller.');
			}
			$view = new MadView( "$this->dir/$router->action.php" );
			$view->componentPath = "$router->projectRoot/$this->dir/";
			return $view->getContents();
		} elseif ( $config->type == 'layout' ) {
			print 'tested';
			$config->test();
			die;
			if ( $config->has('layout') ) {
				print $config->layout;
			}
		} else {
			// 3. controller
			$controllerName = $router->controller . 'Controller';
			$controllerFile = $controllerName . '.php';
			$viewFile = "$this->dir/$router->action.html";
			$modelFile = "$this->dir/$router->controller.php";

			if ( is_file( "$this->dir/$controllerFile" ) ) {
				include_once "$this->dir/$controllerFile";
				$controller = new $controllerName;
				$controller->setConfig( $config );

				$controller->setView( $viewFile );
				if ( is_file( $modelFile ) ) {
					include_once $modelFile;
				}
				$controller->setModel( $router->controller );

				$actionName = $router->action . 'Action';
				// $debug->r( $config );
				$rv = $controller->$actionName();
				return "$rv";
			}
		}
		// $debug->(new MadDebug)->printR( $data->getData() );
		return "$rv";
	}
	function __toString() {
		return $this->getContents();
	}
}

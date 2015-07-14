<?
class MadConfig extends MadAbstractData {
	private static $instance;
	public static function getInstance() {
		self::$instance || self::$instance = new self;
		return self::$instance;
	}

	protected $dir = '';
	protected $keywords = array(
		'views' => 'addViews',
		'js' => 'addJs',
		'css' => 'addCss',
		'instances' => 'addInstances',
		'calls' => 'addCalls',
		'configs' => 'addConfigs',
	);

	private function __construct() {
		$this->css = MadCss::getInstance();
		$this->js = MadJs::getInstance();
		$this->views = new MadData;
		$this->router = MadRouter::getInstance();
		$this->sitemap = MadSitemap::create();

		$file = 'config.json';
		if ( ! is_file( $file ) ) {
			$file = $_SERVER['DOCUMENT_ROOT'] . '/mad/config.json';
		}
		$this->addConfig( $file );
	}
	function addConfig( $file = 'config.json' ) {
		$this->dir = dirName( $file ) . '/';

		$json = new MadJson( $file );
		foreach( $json as $key => $row ) {
			if ( ! isset( $this->keywords[$key] ) ) {
				$this->addInfo( $key, $row );
				continue;
			}
			$method = $this->keywords[$key];
			$this->$method( $row );
		}

		return $this;
	}
	function addViews( $data ) {
		if( empty( $data ) ) {
			return false;
		}
		foreach( $data as $key => $value ) {
			$value = preg_replace( '!^\./!', $this->dir, $value );
			$this->views->$key = new MadView( $value );
		}
	}
	function addJs( $data ) {
		$router = MadRouter::getInstance();
		foreach( $data as $row ) {
			if ( $local = $router->path2url( $this->dir . $row ) ) {
				$this->js->add( $row );
			} else {
				$this->js->add( $row );
			}
		}
		return $this;
	}
	function addCss( $data ) {
		$router = MadRouter::getInstance();
		foreach( $data as $row ) {
			if ( $local = $router->path2url( $this->dir . $row ) ) {
				$this->css->add( $row );
			} else {
				$this->css->add( $row );
			}
		}
		return $this;
	}
	function addInfo( $key, $data ) {
		$this->$key = $data;
		return $this;
	}
	function addInstances( $data ) {
		foreach( $data as $key => $value ) {
			if ( strpos( $value, '::' ) ) {
				$this->$key = $this->createInstance( $value );
			} else if ( strpos( $value, 'new' ) == 0 ) {
				$value = str_replace( 'new ', '', $value );
				$this->$key = $this->createObject( $value );
			}
		}
		return $this;
	}
	function addCalls( $data ) {
		foreach( $json->calls as $key => $value ) {
			$this->call( $value );
		}
		return $this;
	}
	function addConfigs( $data ) {
		foreach( $data as $value ) {
			$this->addConfig( $value );
		}
	}
	private function createObject( $value ) {
		$args = $this->getArgs( $value );
		if ( ! empty( $args ) ) {
			$objectName = substr( $value, 0, strpos( $value, '(' ) );
			$object = new ReflectionClass( $objectName );
			return $object->newInstanceArgs( $args );
		}
		return new $value;
	}
	// this is not use in CONSTANT
	private function getArgs( $string ) {
		if ( $match = preg_match_all( "/(?<=[\"'])(?!,).*?(?=[\"'])/", $string, $args ) ) {
			return $args[0];
		}
		return array();
	}
	private function createInstance( $value ) {
		$parts = explode( '(', $value );
		$func = explode('::', $parts[0] );
		$args = $this->getArgs( $parts[1] );

		if ( ! class_exists( $func[0] ) ) {
			throw new Exception( "Class not found : " . $func[0] );
		}
		return call_user_func_array( $func, $args );
	}
	private function call( $command ) {
		$parts = explode( '(', $command );
		$func = explode('::', $parts[0] );

		$args = $this->getArgs( $parts[1] );

		if ( ! $func[0] = $this->{$func[0]} ) {
			return false;
		}
		return call_user_func_array( $func, $args );
	}
}

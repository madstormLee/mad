<?
class MadConfig extends MadAbstractData {
	private static $instance;
	private function __construct( ) {
	}
	public static function getInstance() {
		self::$instance || self::$instance = new self;
		return self::$instance;
	}
	function addConfig( $file = 'config.json' ) {
		$json = new MadJson( $file );
		$this->data = array_merge_recursive( $this->data, $json->getData() );
		return $this;
	}
	function getCss() {
		$css = MadCss::getInstance();
		if ( ! $this->css ) {
			return $css;
		}
		foreach( $this->css as $value ) {
			$css->add( $value );
		}
		return $css;
	}
	function getJs() {
		$js = MadJs::getInstance();
		if ( ! $this->js ) {
			return $js;
		}
		foreach( $this->js as $value ) {
			$js->add( $value );
		}
		return $js;
	}
	function init2() {
		foreach( $this->data as $key => $value ) {
			if ( ! is_string( $value ) ) {
				continue;
			}
			if ( preg_match( '/\.(html|json|txt)$/', $value ) ) {
				$this->$key = new MadView( $value );
			} else if ( strpos( $value, '::' ) ) {
				$this->$key = $this->createInstance( $value );
			} else if ( 0 === strpos( $value, 'new ' ) ) {
				$this->$key = $this->createObject( $value );
			} else {
				$this->$key = $value;
			}
		}
	}
	function getViews() {
		if ( ! $this->views ) {
			$this->views = array();
		}
		$this->walk( 'views', function( $key, $value ) {
			$this->views->$key = new MadView( $value );
		});
		return $this->views;
	}
	function init() {
		$this->css = $this->getCss();
		$this->js = $this->getJs();
		$this->views = $this->getViews();

		$this->walk( 'instances', function( $key, $value ) {
			if ( strpos( $value, '::' ) ) {
				$this->$key = $this->createInstance( $value );
			} else if ( strpos( $value, 'new' ) == 0 ) {
				$value = str_replace( 'new ', '', $value );
				$this->$key = $this->createObject( $value );
			}
		});
		$this->walk( 'calls', function( $key, $value ) {
			$this->call( $value );
		});
		$this->walk( 'components', function( $key, $value ) {
			$this->$key = new MadComponent( $value );
		});
		return $this;
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
			return new MadNull;
		}
		return call_user_func_array( $func, $args );
	}
	private function call( $command ) {
		$parts = explode( '(', $command );
		$func = explode('::', $parts[0] );

		$args = $this->getArgs( $parts[1] );

		if ( ! $func[0] = $this->g->{$func[0]} ) {
			return false;
		}
		return call_user_func_array( $func, $args );
	}
}

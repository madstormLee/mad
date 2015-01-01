<?
class MadConfig extends MadAbstractData {
	private static $instance;

	private function __construct() {
		$this->css = MadCss::getInstance();
		$this->js = MadJs::getInstance();
		$this->views = new MadData;
		$this->router = MadRouter::getInstance();
		$this->sessionUser = MadSessionUser::getInstance();
		$this->sitemap = MadSitemap::create();

		$this->addConfig();
	}
	public static function getInstance() {
		self::$instance || self::$instance = new self;
		return self::$instance;
	}
	function addView( $data ) {
		if( empty( $data ) ) {
			return false;
		}
		foreach( $data as $key => $value ) {
			$this->views->$key = new MadView( $value );
		}
	}
	function addConfig( $file = 'config.json' ) {
		$json = new MadJson( $file );
		$this->info = $json->info;
		$this->default = $json->default;
		$this->database = $json->database;

		$this->js->addAll( $json->js );
		$this->css->addAll( $json->css );

		$this->addView( $json->views );

		if ( isset( $json->instances ) ) {
			foreach( $json->instances as $key => $value ) {
				if ( strpos( $value, '::' ) ) {
					$this->$key = $this->createInstance( $value );
				} else if ( strpos( $value, 'new' ) == 0 ) {
					$value = str_replace( 'new ', '', $value );
					$this->$key = $this->createObject( $value );
				}
			}
		}
		if ( isset( $json->calls ) ) {
			foreach( $json->calls as $key => $value ) {
				$this->call( $value );
			}
		}
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

		if ( ! $func[0] = $this->{$func[0]} ) {
			return false;
		}
		return call_user_func_array( $func, $args );
	}
}

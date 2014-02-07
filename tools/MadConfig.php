<?
class MadConfig extends MadAbstractData {
	private $json;

	function __construct( $file ) {
		$json = new MadJson( $file );
		$this->json = $json;
		$this->init();
	}
	function add( $file ) {
		$config = self::getInstance();
		$units = explode('.', $file );
		$extension = array_pop( $units );
		if ( $extension == 'json' ) {
			$config->addJson( $file );
		}
	}
	function init() {
		$json = $this->json;

		// setting type
		$this->type = 'php';
		if( $json->type ) {
			$this->type = $json->type;
		}

		if ( $json->useSession ) {
			MadSession::start();
		}
		foreach( $json->instances as $key => $value ) {
			if ( strpos( $value, '::' ) ) {
				$this->g->$key = $this->createInstance( $value );
			} else {
				$this->g->$key = $this->createObject( $value );
			}
		}
		foreach( $json->calls as $command ) {
			$this->call( $command );
		}
		foreach( $json->components as $key => $dir ) {
			$this->$key = new MadComponent( $dir );
		}
		// new
		$css = MadCss::getInstance();
		$js = MadJs::getInstance();
		foreach( $json->resources as $key => $file ) {
			if ( preg_match( '/\.(html|json|txt)$/', $file ) ) {
				$this->$key = MadFile::create( $file );
			} else if ( preg_match( '/.css$/', $file ) ) {
				$css->add( "$dir/$file" );
			} else if ( preg_match( '/.js$/', $file ) ) {
				$js->add( "$dir/$file" );
			} else {
				$this->$key = $value;
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

		if ( ! $func[0] = $this->g->{$func[0]} ) {
			return false;
		}
		return call_user_func_array( $func, $args );
	}
}

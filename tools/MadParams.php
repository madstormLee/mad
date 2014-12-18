<?
class MadParams extends MadAbstractData {
	public function __construct( $name = '' ) {
		if ( is_array( $name ) ) {
			$this->data = $name;
			return true;
		}
		if ( $name == '' ) {
			$this->data = &$GLOBALS;
		} elseif ( isset( $GLOBALS[$name] )  ) {
			$this->data = &$GLOBALS[$name];
		} if ( $name == '_SERVER' ) {
			$this->data = &$_SERVER;
		}
	}
	public static function create( $target ) {
		if ( $target == 'get' ) {
			return new self( $_GET );
		} else if ( $target == 'server' ) {
			return new self( $_SERVER );
		} else if ( $target == 'post' ) {
			return new self( $_POST );
		} else if ( $target == 'files' ) {
			return new self( $_FILES );
		} else if ( $target == 'cookie' ) {
			return new self( $_COOKIE );
		}
		return new self;
	}
	function query() {
		return http_build_query( $this->data );
	}
	function except( $exceptions ) {
		if ( empty( $this->data ) ) {
			return '';
		}
		if ( ! is_array( $exceptions ) ) {
			$exceptions = array( $exceptions );
		}
		$queries = $this->data;
		foreach( $exceptions as $exception ) {
			unset( $queries[$exception] );
		}
		return http_build_query( $queries );
	}
	function replace( $replace, $sep = '&' ) { // sep need when use &amp;
		$queries = $this->data;

		$data = array_filter( explode( $sep, $replace ) );
		foreach( $data as $row ) {
			list( $key, $value )  = explode( '=', $row );
			$queries[$key] = $value;
		}
		return http_build_query( $queries );
	}
	function __toString() {
		return $this->query();
	}
}

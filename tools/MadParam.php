<?
// this class is temporal namespace;
class MadParam extends MadData {

	static function create( $target ) {
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
	function saveJson( $file ) {
		return file_put_contents( $file, $this->json() );
	}
	static function except( $exceptions ) {
		if ( empty( $_GET ) ) {
			return '';
		}
		if ( ! is_array( $exceptions ) ) {
			$exceptions = array( $exceptions );
		}
		$queries = $_GET;
		foreach( $exceptions as $exception ) {
			unset( $queries[$exception] );
		}
		return http_build_query( $queries );
	}
	static function replace( $replace, $sep = '&' ) { // sep need when use &amp;
		$queries = $_GET;

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

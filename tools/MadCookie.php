<?
class MadCookie extends MadAbstractData {
	protected $data = array();
	protected $key = 'cookie';

	protected $time = 0;
	protected $path = '/';
	protected $domain = '';

	public static function addHistory() {
		$history = new self('history');
		$router = MadRouter::getInstance();

		if ( $history->isEmpty() ) {
			$history->set( 0, '/' );
		}

		if ( $router->ajax || $router->method == 'POST' || $history->end() == $router->request ) {
			return false;
		}
		if ( $history->count() > 10 ) {
			$history->shift();
		}
		$history->push( $router->request );
	}
	function __construct( $key = 'cookie' ) {
		$this->key = $key;
		if ( ! isset( $_COOKIE[$key] ) ) {
			$_COOKIE[$key]=array();
		}
		$this->data = &$_COOKIE[$key];
		$this->time = strToTime( '+1 month' );
	}
	function set( $key, $value = '' ) {
		if ( setcookie( $this->getName($key), $value, $this->time, $this->path) ) {
			$this->data[$key] = $value;
		}
		return $this;
	}
	function push( $value ) {
		array_push( $this->data, $value );
		end( $this->data );
		$this->set( key( $this->data ), $value );
		return $this;
	}
	function shift() {
		$rv = reset( $this->data );
		$key = key( $this->data );
		unset($this->$key);
		return $rv;
	}
	function get( $key ) {
		if ( isset( $this->data[$key] ) ) {
			return $this->data[$key];
		}
		return false;
	}
	// @override
	function offsetUnset($key) {
		if ( isset( $this->data[$key] ) ) {
			if ( $result = setcookie( $this->getName($key), '', 1, $this->path ) ) {
				unset( $this->data[$key] );
			}
			return $result;
		}
		return $this;
	}
	/************************ utils ************************/
	protected function getName( $key ) {
		return $this->key . "[$key]";
	}
	/************************ getter/setter ************************/
	function setTime( $time ) {
		$this->time = $time;
		return $this;
	}
	function getTime() {
		return $this->time;
	}
	function setPath( $path ) {
		$this->path = $path;
		return $this;
	}
	function getPath() {
		return $this->path;
	}
	function setDomain( $domain ) {
		$this->domain = $domain;
		return $this;
	}
	function getDomain() {
		return $this->domain;
	}
}

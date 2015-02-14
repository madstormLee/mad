<?
class MadJs extends MadAbstractData {
	protected static $instance;
	protected $router;
	protected $data = array();

	public static function getInstance(){
		return self::$instance ? self::$instance : self::$instance = new self;
	}
	private function __construct() {
		$this->router = MadRouter::getInstance();
	}
	function set( $key, $value = '' ) {
		if ( empty( $value ) ) {
			$value = $key;
		}
		return $this->add( $value );
	}
	function addAll( $data ) {
		if( empty( $data ) ) {
			return false;
		}
		foreach( $data as $value ) {
			$this->add( $value );
		}
	}
	function add( $value ) {
		if ( ! in_array( $value, $this->data ) ) {
			$this->data[] = $value;
		}
		return $this;
	}
	function addExists( $file ) {
		if ( is_file( $this->router->pathAdjust($file) ) ) {
			return $this->add( $file );
		}
		return $this;
	}
	function addFirst( $value ) {
		if ( ! in_array( $value, $this->data ) ) {
			array_unshift( $this->data, $value );
		}
		return $this;
	}
	function addNext( $add, $target ) {
		foreach( $this->data as $key => $value ) {
			if ( false !== strpos( $value, $target ) ) {
				array_splice( $this->data, $key+1, 0, $add );
				break;
			}
		}
		return $this;
	}
	function remove($target) {
		foreach ( $this->data as $key => $value ) {
			if ( false !== strpos( $value, $target ) ) {
				unset($this->data[$key] );
			}
		}
		return $this;
	}
	function clear() {
		$this->data = array();
		return $this;
	}
	function __toString(){
		$rv = array();
		foreach ( $this->data as $src ){
			$rv[] = "<script type='text/javascript' src='$src'></script>\n";
		}
		return implode( "\n", $rv );
	}
	/******************** js utilities *******************/
	function alert($msg){
		$msg = str_replace( "'", '"', $msg );
		$msg = str_replace( "\n", '\n', $msg );
		print "<script>alert('$msg');</script>";
		return $this;
	}
	function replace( $url ) {
		$url = $this->router->urlAdjust( $url );
		print  "<script>location.replace('$url');</script>";
		exit;
	}
	function move( $url ) {
		$url = $this->router->urlAdjust( $url );
		print  "<script>location.href=('$url');</script>";
		exit;
	}
	function back() {
		print "<script>history.back();</script>";
		exit;
	}
	function replaceBack() {
		$server = MadParams::create('_SERVER');
		if( $server->HTTP_REFERER ) {
			$this->replace( $server->HTTP_REFERER );
		}
		$this->back();
	}
}

<?
class MetaManager {
	private static $instance;
	private $tags = array(); 
	private $httpEquivs = array( 'content-type', 'expires', 'refresh', 'set-cookie');
	private $names = array( 'author' , 'description' , 'keywords' , 'generator' , 'revised');
	private $data = array();

	private function __construct(){
	}
	public static function getInstance(){
		if(! isset(self::$instance) ){
			self::$instance = new self;
		}
		return self::$instance;
	}
	function __set( $key, $value ) {
		$this->data[$key] = $value;
	}
	function set( $key, $value ) {
		$this->data[$key] = $value;
	}
	function __toString() {
		$rv = '';
		foreach ( $this->data as $key => $value ) {
			if ( in_array($key, $this->httpEquivs ) ) {
				$rv .= "<meta http-equiv='$key' content='$value' />";
			} else if ( in_array($key, $this->names ) ) {
				$rv .= "<meta name='$key' content='$value' />";
			} else {
				$rv .= "<meta name='others' content='$value' />";
			}
		}
		return $rv;
	}
}

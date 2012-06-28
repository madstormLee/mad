<?
class MadRepository {
	private static $repository;
	private $reposName;

	function __construct($reposName) {
		$this->reposName = $reposName;
		self::$repository[$reposName]['domain'] = $reposName;
	}
	function addData( $data = array() ) {
		self::$repository[$this->reposName] = array_merge( self::$repository[$this->reposName], $data );
	}
	function __set( $key, $value ){
		self::$repository[$this->reposName][$key]=$value;
	}
	function __get( $key ) {
		if ( isset(self::$repository[$this->reposName][$key]) )
			return self::$repository[$this->reposName][$key];
		return $key;
	}
	function __isset( $key ) {
		if ( isset( self::$repository[$this->reposName][$key] ) ) {
			return true;
		}
		return false;
	}
	function __toString() {
		return get_class($this);
	}
	function __call($method, $args) {
		if ( isset(self::$repository[$method]) && is_array(self::$repository[$method] ) ){
			return self::$repository[$method];
		}
	}
	function get($reposName='') {
		$rv = array();
		if ( empty($reposName) ) {
			$rv =  self::$repository[$this->reposName];
		} else {
			if ( array_key_exists($reposName, self::$repository) ) {
				$rv = self::$repository[$reposName];
			}
		}
		return $rv;
	}
	function set($reposName) {
	}
	function viewDomains() {
		foreach( self::$repository as $key => $value ) {
			print $key . '<br />';
		}
	}
	function test() {
		printR(self::$repository[$this->reposName]);
	}
	function testAll() {
		printR(self::$repository);
	}
}

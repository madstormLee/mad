<?
class MadManager { // All Managers are singleton.
	protected $data = array(); 
	protected $prefix = '';

	protected function __construct() {
	}
	function __set( $key, $value ){
		$data = $this->data;
		if ( ! in_array( $value, $data ) ) { // insert only unique value.
			$this->data[$key] = $value;
		}
	}
	function __get( $key ) {
		return $this->data[$key];
	}
	function __toString() {
		return get_class($this);
	}
	function setDir($dirName){
		$this->dirName = $dirName;
	}
	function setPrefix( $prefix ) {
		$this->prefix = $prefix;
	}
	function set($value, $dirName='') {
		if ( ! empty($dirName) ) $this->setPrefix( $dirName );
		$value = $this->dirName.$value;
		$data = $this->data;
		if ( ! in_array( $value, $data ) ) { // insert only unique value.
			$this->data[] = $value;
		}
	}
	function remove($value) {
		foreach ( $this->data as $key => $v ) {
			if ( $v == $value ) {
				unset($this->data[$key] );
			}
		}
	}
	function test() {
		printR($this->data);
	}
	function clear() {
		$this->tags = array();
	}
}

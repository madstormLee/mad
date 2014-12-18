<?
class MadNavi extends Mad {
	protected $data = array();
	function __construct() {
		parent::__construct();
	}
	function __set( $key, $value ) {
		$this->data[$key] = $value;
	}
	function set( $data = array() ) {
		$this->data = $data;
	}
	function __toString() {
		$rv = '<ul>';
		foreach( $this->data as $name => $href ) {
			$rv .= "<li><a href='$href'>$name</a></li>";
		}
		$rv .= '</ul>';
		return $rv;
	}
}

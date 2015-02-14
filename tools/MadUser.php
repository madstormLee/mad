<?
class MadUser {
	protected $levels = null;
	protected $level = 1000;

	function __construct() {
		$this->levels = new MadData( array(
			'root' => 0,
			'admin' => 1,
			'localAdmin' => 5,
			'member' => 200,
			'user' => 255,
			'default' => 1000,
		) );
	}
	function __get( $key ) {
		if ( isset( $this->data[$key] ) ) {
			return $this->data[$key];
		}
		return false;
	}
	function getLevel( $name = '' ) {
		if ( empty( $name ) ) {
			return $this->level;
		}
		return $this->levels->$name;
	}
	function getDefaultLevel() {
		if ( ! $this->levels->default ) {
			$this->levels->default = 300;
		}
		return $this->levels->default;
	}
}

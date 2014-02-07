<?
class Ghost {
	private $url = 'http://tools.madstorm.org/madtools/';
	private $protect = '';
	private $phases = array(
			1 => 'removeProtection',
			2 => 'adminSetting',
			3 => 'programSetting',
			);

	public function __construct( $protect = 'ThunderStorm') {
		$this->protect = $protect;
		if ( ! $this->phase ) {
			$this->phase = 1;
		}
		$action = $this->phases[$this->phase];
		if ( true === $this->$action() ) {
			$this->phaseUp();
		}
		if ( $this->phase() > 3 ) {
			print "<script>location.replace('$this->phpStorm');</script>";
		}
	}
	public function phase() {
		return $this->phase;
	}
	public function getUrl() {
		return $this->url;
	}
	private function removeProtection() {
		if ( $this->post('protect') === $this->protect ) {
			return true;
		}
		return false;
	}
	private function adminSetting() {
		if ( $id = $this->post('id') && $pw = $this->post('pw') ) {
			$this->id = $id;
			$this->pw = $pw;
			return true;
		}
		return false;
	}
	private function programSetting() {
		if ( ! $program = $this->post('program') ) {
			return false;
		}
		foreach( $program as $target ) {
			$this->install( $target );
		}
		return true;
	}
	private function install( $target ) {
		// 뭐, 대략 이런 식이다.
		$source = 'source.tar.gz';
		file_put_contents( $source, file_get_contents( "http://localhost/madtools/project/download?project=$target" ) );
		`tar -xzf $source`;
		unlink( $source );
	}
	private function phaseUp() {
		++ $this->phase;
		return $this;
	}
	function __set( $key, $value ) {
		$_SESSION[$key] = $value;
	}
	function __get( $key ) {
		if ( isset( $_SESSION[$key] ) ) {
			return $_SESSION[$key];
		}
		return false;
	}
	/************* functions *************/
	private function post( $key ) {
		return isset( $_POST[$key] ) ? $_POST[$key] : false;
	}
}

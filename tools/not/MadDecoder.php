<?
class MadDecoder {
	private $data;
	function __construct() {
	}
	function setFromIniFile( $iniFile, $reverse = false ) {
		$decodeInfo = parse_ini_file( $iniFile, true );

		if ( $reverse == true ) {
			foreach( $decodeInfo as $key => $info ) {
				$decodeInfo[$key] = array_combine( array_values($info), array_keys($info) );
			}
		}
		$this->set( $decodeInfo );
	}
	function set( $data ) {
		$this->data = $data;
	}
	function decode( $data ) {
		foreach( $this->data as $key => $info ) {
			if ( isset( $data[$key] ) ) {
				$value = $data[$key];
				$data[$key] = ckKey( $value, $info );
			}
		}
		return $data;
	}
}

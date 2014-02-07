<?
class MadIni extends MadData {
	protected $data = array();
	private $file;

	function __construct( $iniFile = '') {
		$this->load( $iniFile );
	}
	function getFile() {
		return $this->file;
	}
	function setFile( $file ) {
		if ( end( explode('.', $file) ) !== 'ini' ) {
			$file = $file . '.ini';
		}
		$this->file = $file;
		return $this;
	}
	function load( $file = '' ) {
		if ( ! empty( $file ) ) {
			$this->setFile( $file );
		}
		if( is_file($this->file) ) {
			$this->setData( parse_ini_file($this->file, true) );
		}
		return $this;
	}
	function getContents() {
		$contents = array();
		foreach( $this->data as $section => $member ) {
			if ( is_array($member) ) {
				$contents[] = "[$section]";
				foreach( $member as $key => $value ) {
					$contents[] = "$key = \"$value\"";
				}
			} else {
				$contents .= "$section = \"$member\"";
			}
		}
		return implode("\n",$contents);
	}
	function save() {
		if ( empty($this->data) || empty( $this->file ) ) {
			return false;
		}
		$contents = $this->getContents();

		$dir = dirName( $this->file );
		if ( ! is_dir($dir) ) {
			mkdir($dir,0777,true);
		}
		return file_put_contents($this->file, $contents) ? 1:0;
	}
	function __toString() {
		return $this->getContents();
	}
	function test() {
		print BR;
		print $this->file;
		print BR;
		(new MadDebug)->printR( $this->data );
	}
}

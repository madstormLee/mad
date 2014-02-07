<?
class MadLogger {
	private $file = "logs/Logger.log";
	private $data = array();

	private $locale = 'kr';

	function __construct( $file = '' ) {
		$this->setFile( $file );
	}
	function setFile( $file ) {
		$this->file = $file;
		return $this;
	}
	function add( $contents ) {
		$this->data[] = $contents;
	}
	function mkdir( $dir ) {
		if ( ! mkdir ( $dir, 0777, true ) ) {
			return false;
		}
	}
	function ckDir( $dir ) {
		if ( is_dir( $dir ) ) {
			return true;
		}
		return $this->mkdir( $dir );
	}
	function save() {
		$contents = implode( "\n", $this->data );
		$dir = dirName( $this->file );
		if ( ! $this->ckDir( $dir ) ) {
			return false;
		}
		$date = date('Ymd', strToTime( "$this->edate +1 day" ) );
		return file_put_contents( $this->file, $contents . "\n" , FILE_APPEND );
	}
	function test() {
		print $this->file;
		(new MadDebug)->printR( $this->data );
	}
}


<?
class MadFileLog {
	private $isDebug = true;
	private $file = '';

	function __construct() {
		$this->setFile();
	}
	function checkDate() {
		$this->setFile();
	}
	function setFile( $file = '' ) {
		if ( ! $file ) {
			$fileDate = date('Ymd');
			$file = "logs/item_saver_$fileDate.log";
		}
		$this->file = $file;
		return $this;
	}
	function log( $msg ) {
		if( $this->isDebug == false ) {
			return false;
		}
		$contents =  date("Y-m-d H:i:s") . " $msg\n";

		return file_put_contents( $this->file, $contents, FILE_APPEND );
	}
}


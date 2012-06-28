<?
class BackupList extends MadList {
	private $dir;
	private $lastCTime = -1;

	function __construct() {
		parent::__construct();
	}
	function mkdir( $dir ) {
		return mkdir( $dir, 0777, true );
	}
	private function setLastCTime() {
		if ( empty( $this->data ) ) {
			$this->setData();
		}
		$this->lastCTime = 0;
		foreach( $this as $file ) {
			if ( $file->getCTime() > $this->lastCTime ) {
				$this->lastCTime = $file->getCTime();
			}
		}
		return $this;
	}
	function getLastBackupDate() {
		if ( $this->lastCTime === -1 ) {
			$this->setLastCTime();
		}
		if ( $this->lastCTime == 0 ) {
			return "not yet";
		} else {
			return date( 'Y-m-d h:i:s', $lastCTime );
		}
	}
	function setDir( $dir ) {
		$this->dir = $dir;
		return $this;
	}
	function getDir() {
		return $this->dir;
	}
	function setData() {
		$json = new MadJson( "json/BackupList" );
		if ( ! is_dir( $json->dir ) ) {
			$this->mkdir( $json->dir );
		}
		$files = scandir( $json->dir );
		foreach( $files as $file ) {
			if ( 0 === strpos( $file, '.' ) ) {
				continue;
			}
			$this->data[] = new MadFile( $json->dir . $file );
		}
		$this->searchTotal = count( $this->data );

		$this->limit->setTotal( $this->searchTotal );

		return $this;
	}
}


<?
class Backup {
	private $froms;
	private $dir = 'utils/backup/data';

	function __construct() {
		$this->froms = new MadData( array(
			'patch' => ROOT . '../patch/',
			'backup' => ROOT . '../patchBackup/',
		) );
		$this->backupFiles = array();
	}
	function getIndex() {
		$rv = array();
		foreach( glob( "$this->dir/*", GLOB_ONLYDIR ) as $dir ) {
			$row = array();
			$row['name'] = $dir;
			$row['md5'] = md5_file( $dir );
			$rv[] = $row;
		}
		return new MadData($rv);
	}
	function getLastDate() {
		return date('Y-m-d H:i:s');
	}
	// todo: from ts/backup
	function getIndexTemp() {
		return new MadData;
		$json = new MadJson( "json/BackupList" );
		if ( ! is_dir( $json->dir ) ) {
			$this->mkdir( $json->dir );
		}
		foreach( glob( "$json->dir/*" ) as $file ) {
			$this->data[] = new MadFile( $file );
		}
		$this->searchTotal = count( $this->data );
		$this->limit->setTotal( $this->searchTotal );

		return new MadData($this->data);
	}
	function lastCTime() {
		$rv = 0;
		foreach( $this->getIndex() as $file ) {
			if ( $file->ctime() <= $rv ) {
				continue;
			}
			$rv = $file->ctime();
		}
		return $rv;
	}
	function getMTime() {
		$mtime = $this->lastCTime();
		if ( $mtime == 0 ) {
			return '';
		}
		return "--newer-mtime=" . date('Y-m-d H:i:s', $mtime);
	}

	function backup($patchFiles) {
		$patchFiles = explode("\n",$patchFiles);
		$backupFiles = array();
		foreach( $patchFiles as $patchFile ) {
			if ( is_file ( ROOT . $patchFile) ) {
				$backupFiles[] = $patchFile;
			}
		}
		$backupFiles = implode(' ', $backupFiles);

		$router = MadRouter::getInstance();

		$date = date('Ymd_his');
		$file = $this->froms['backup']."$date.tar.gz";
		$fileName = date('Ymd_His') . '.tar.gz';
		$mtime = $this->getMTime();
		$result = `cd $router->project; tar $mtime -czf $file $backupFiles`;
	}
	function patch( $file ) {
		$file = $this->patchDir . $file;
		if ( ! is_file($file) ) {
			throw new Exception('File not found.');
		}

		$this->backup();

		ob_start();
		`tar -C $root -xvf $file`;
		return ob_get_clean();
	}
	function getPatches() {
		return $this->getIndex( $this->froms['patch'] );
	}
	function getBackups() {
		return $this->getIndex( $this->froms['backup'] );
	}
	function delete( $id ) {
		if ( ! is_file( $id ) ) {
			throw new Exception( 'File not found.' );
		}
		if ( ! is_writable( $id ) ) {
			throw new Exception( 'File is not writable.' );
		}
		return @unlink( $id );
	}
}

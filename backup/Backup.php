<?
class Backup {
	private $froms;
	function __construct() {
		$this->className = get_class($this);
		$this->froms = new MadData( array(
			'patch' => ROOT . '../patch/',
			'backup' => ROOT . '../patchBackup/',
		) );
		$this->backupFiles = array();
		$this->ini = new MadIniManager( MADINI.$this->className.DS.'backup.ini');
	}
	function getIndex( $targetDir ) {
		$rv = array();
		$lists = scandir( $targetDir );
		foreach( $lists as $file ) {
			if ( is_dir( $targetDir . $file ) ) {
				continue;
			}
			$fileMd5 = md5_file( $targetDir . $file );
			$row['name'] = $file;
			$row['md5'] = $fileMd5;
			$rv[] = $row;
		}
		return $rv;
	}

	function backup($patchFiles) {
		$root = realpath($_SERVER['DOCUMENT_ROOT'].'/').'/';
		$patchFiles = explode("\n",$patchFiles);
		$backupFiles = array();
		foreach( $patchFiles as $patchFile ) {
			if ( is_file ( ROOT . $patchFile) ) {
				$backupFiles[] = $patchFile;
			}
		}
		$backupFiles = implode(' ', $backupFiles);
		$backupTar = $this->froms['backup'].'backup_'.date('Ymd_His').'.tar';
		print `cd $root; tar -cf $backupTar $backupFiles`;
	}
	function getPatches() {
		return $this->getIndex( $this->froms['patch'] );
	}
	function getBackups() {
		return $this->getIndex( $this->froms['backup'] );
	}
}

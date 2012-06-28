<?
class BackupController extends Preset {
	function indexAction() {
		return new MadView;
	}
	function writeAction() {
	}
	function listAction() {
		$list = new BackupList;
		
		$this->main->list = $list;
		return $this->main;
	}
	function backupAction() {
		$list = new BackupList;
		$fileName = 'backup_' . date('YmdHis') . '.tar.gz';
		$mtime = "";
		$lastBackupDate = $list->getLastBackupDate();
		if ( $lastBackupDate != 'not yet' ) {
			$mtime = "--newer-mtime=$lastBackupDate ";
		}
		print $statement = "tar $mtime -czf $fileName";
		die;
	}
}

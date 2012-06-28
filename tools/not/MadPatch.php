<?
class MadPatch {
	private $className;
	private $ini;
	private $froms;

	function __construct() {
		$this->className = get_class($this);
		$this->froms = array(
				'patch' => ROOT . '../patch/',
				'backup' => ROOT . '../patchBackup/',
				);

		$this->backupFiles = array();
		$this->ini = new MadIniManager( MADINI.$this->className.DS.'backup.ini');
	}
	function getLastBackupDate() {
		$lastBackup = $this->ini->lastBackup;
		return $lastBackup['time'];
	}
	function backupAction() {
		if ( ! $mtime = ckPost('mtime') ) {
			alert('잘못된 접근 입니다.','back','replace');
		}
		$backupDate = date('Y-m-d_h:i:s');
		$date = date('Ymd_his');
		$fileName = $_SERVER['HTTP_HOST'].'_'. $date .'.tar';
		$absFile = $this->froms['backup'] . $fileName;
		$root = realpath($_SERVER['DOCUMENT_ROOT'].'/').'/';
		$targets = '*';
		// $this->ini->lastBackup
		$result = `cd $root; tar --newer-mtime='$mtime' -cf $absFile $targets`;
		alert("$fileName 파일이 백업되었습니다.", 'back', 'replace');
	}
	function backupAllAction() {
		$date = date('Ymd_his');
		$targets = 'admin/* main/* mad/* ini/*';
		$fileName = 'mkeAll_'. $date .'.tar';
		$absFile = $this->froms['backup'] . $fileName;
		$root = realpath($_SERVER['DOCUMENT_ROOT'].'/').'/';
		$result = `cd $root; tar -cf $absFile $targets`;
		alert("$fileName 파일이 백업되었습니다.", 'back', 'replace');
	}
	function getPatches() {
		return $this->scanDir( $this->froms['patch'] );
	}
	function getBackups() {
		return $this->scanDir( $this->froms['backup'] );
	}
	function downloadAction() {
		$from = ckKey(ckGet('from'), $this->froms);
		$name = ckGet('name');
		if ( ! is_file($from . $name ) ) {
			alert('파일이 존재하지 않습니다.', 'back', 'replace');
		}
		if(strstr($_SERVER['HTTP_USER_AGENT'], "MSIE 5.5")) {
			header("Content-Type: doesn/matter");
			header("Content-Disposition: filename=$name");
			header("Content-Transfer-Encoding: binary");
		} else {
			Header("Content-type: file/unknown");
			Header("Content-Disposition: attachment; filename=$name");
			Header("Content-Description: PHP Generated Data");
		}
		header("Pragma: no-cache");
		header("Expires: 0");
		print file_get_contents($from . $name );
		die;
	}
	private function scanDir( $targetDir ) {
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
	function uploadAction() {
		$message = '패치 파일이 저장 되었 습니다.';
		if ( is_file($_FILES['patchFile']['tmp_name']) ) {
			$fileMd5 =  md5_file($_FILES['patchFile']['tmp_name']);
		} else {
			$destination = $this->patchDir . $_FILES['patchFile']['name'];
			if ( is_file( $destination ) ) {
				$message = 'file already exists';
			} else {
				$result = move_uploaded_file($_FILES['patchFile']['tmp_name'], $destination);
			}
		}
		alert($message, 'back', 'replace' );
	}
	function patchAction() {
		$this->targetFile = $_GET['name'];
		$root = realpath($_SERVER['DOCUMENT_ROOT'].'/').'/';
		$absFile = $this->patchDir . $_GET['targetFile'];
		if ( isset($_GET['from']) && $_GET['from'] == 'backup' ) {
			$absFile = $this->backupDir . $_GET['targetFile'];
		}
		if ( is_file($absFile) ) {
			print '<p>파일이 존재합니다. 파일이 정상적인지 확인하고 있습니다.</p>';
			print '<p>파일의 압축을 확인하는 중입니다.</p>';
			flush();
			$absFile = str_replace('(','\(', $absFile);
			$absFile = str_replace(')','\)', $absFile);
			print '<pre>';
			print $patchFiles = `tar -tf $absFile`;
			print '</pre>';
			print '<p>해당 파일을 백업하고 있습니다.</p>';
			flush();
			$this->backup($patchFiles);
			print '<p>압축을 풀고 있습니다.</p>';
			print '<pre>';
			print `tar -C $root -xvf $absFile`;
			print '</pre>';
			flush();
			print '<p>패치가 완료되었습니다.</p>';
		}
	}
	private function backup($patchFiles) {
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
	private function deleteAction() {
		$result = false;
		$message = '삭제할 수 없습니다.';
		$absFile = $this->backupDir . $_GET['targetFile'];
		$absFile = $this->patchDir . $_GET['targetFile'];
		if ( is_file ( $absFile ) ) {
			$result = unlink( $absFile );
		}
		if ( $result ) {
			$message = '삭제 되었습니다.';
		}
		if ( !empty( $_SERVER['HTTP_REFERER'] ) ) {
			$target = $_SERVER['HTTP_REFERER'];
			print "<script>alert('$message');</script>";
			print "<script>location.replace('$target');</script>";
		} else {
			print '잘못된 접근 입니다.';
		}
		die;
	}
}

<?
class Uploader {
	function __construct() {
		parent::__construct();
		$this->madlog = MadLog::getInstance('user');
		$this->table = 'MadFileManager';
		if ( isset ( $_POST[$this->controller]) ) {
			$action = $_POST[$this->controller].'Action';
			$this->$action();
		}
	}
	function indexAction() {
	}
	function formAction() {
		$this->setFront(MadController::MAINONLY_LAYOUT);
	}
	private function insAction() {
		if ( ! $this->madlog->isLogin() ) {
			alert('로그인 후에 사용하실 수 있습니다.', 'back', 'replace');
		}
		$user = $this->madlog->getUserId();
		foreach ($_FILES['files']['error'] as $key => $error) {
			if ($error != UPLOAD_ERR_OK) { continue; }

			$name = $_FILES["files"]["name"][$key];
			$fileDir = $this->getFileDir($name);
			if ( $fileDir == false ) {
				print 'not allowed';
				continue;
			} 
			$webDir = "/upload/$user/$fileDir/";
			$targetDir = ROOT.$webDir;
			if ( ! is_dir($targetDir) ) {
				mkdir($targetDir,0777,true);
			}
			$tmp_name = $_FILES['files']['tmp_name'][$key];
			$result = move_uploaded_file($tmp_name, "$targetDir/$name");
			if ( $result !== true ) {
				die;
				alert('저장에 문제가 발생하였습니다.\n관리자에게 문의하세요.', 'back', 'replace');
			} else {
				$fileSize = $_FILES['files']['size'][$key];
				$this->saveFileInfo($webDir, $name, $fileSize);
			}
		}
	}
	private function getFileDir($name) {
		$images = array('gif','jpg','jpeg','png');
		$movies = array('flv','avi','wmv','asf','mpeg');
		$texts = array('doc','xls','txt');

		$dotSeparated = explode('.',$name);
		$extension = array_pop($dotSeparated);
		if ( in_array( $extension, $images ) ) {
			$rv = 'images';
		}
		else if ( in_array( $extension, $movies ) ) {
			$rv = 'movies';
		}
		else if ( in_array( $extension, $texts ) ) {
			$rv = 'texts';
		}
		else {
			$rv = false;
		}
		return $rv;
	}
	private function saveFileInfo($webDir, $name, $brief) {
		$link = $webDir.$name;
		$userId = $this->madlog->getUserId();
		$dotSeparated = explode('.',$name);
		$ext = array_pop($dotSeparated);
		$wDate => 'now()';
		$arr = compact ( 'userId', 'link', 'ext', 'name', 'brief', 'wDate' );
		$set = new MadSet($arr);
		$query = "insert into $this->table $set";
		$q = new Q($query);
	}
}

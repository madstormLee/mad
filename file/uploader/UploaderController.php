<?
class UploaderController extends MadController {
	private $table;

	function galleryInsertAction() {
		if ( $_FILES['upload']['error'] != UPLOAD_ERR_OK ) {
			return false;
		}
		$targetDir = '/photo';
		$fileName = $_FILES['upload']['name'];
		$file = new MadFile( $fileName );
		$name = md5(uniqid()) . '.' . $file->getExtension($fileName);
		$tmp_name = $_FILES['upload']['tmp_name'];
		$result = move_uploaded_file($tmp_name, ROOT."$targetDir/$name");
		$this->url = "$targetDir/$name";
	}
	function writeTestAction() {
	}
	function insertOldAction() {
		foreach ($_FILES['files']['error'] as $key => $error) {
			if ($error != UPLOAD_ERR_OK) { continue; }

		$name = $_FILES["files"]["name"][$key];
		$fileDir = $this->getFileDir($name);
		if ( $fileDir == false ) {
			return 'not allowed';
		} 
		$webDir = "/upload/$user->userId/$fileDir/";
		$targetDir = ROOT.$webDir;
		if ( ! is_dir($targetDir) ) {
			mkdir($targetDir,0777,true);
		}
		$tmp_name = $_FILES['files']['tmp_name'][$key];
		$result = move_uploaded_file($tmp_name, "$targetDir/$name");
		if ( $result !== true ) {
			throw new Exception('???å¿¡ ??Á¦?? ?ß»??Ï¿??À´Ï´?.\n?????Ú¿??? ?????Ï¼???.');
		}
		$fileSize = $_FILES['files']['size'][$key];
		$this->saveFileInfo($webDir, $name, $fileSize);
		}
	}
	private function getFileDir($name) {
		$images = array('gif','jpg','jpeg','png');
		$movies = array('flv','avi','wmv','asf','mpeg');
		$texts = array('doc','xls','txt');

		$ext = $this->getExt($name);
		if ( in_array( $extension, $images ) ) {
			return 'images';
		}
		else if ( in_array( $extension, $movies ) ) {
			return 'movies';
		}
		else if ( in_array( $extension, $texts ) ) {
			return 'texts';
		}
		return  false;
	}
}

<?
class MadFileUploader {
	private $flag = false;
	private $uploadDir;
	private $postName = '';
	private $acceptables = array();
	private $availableRules = array(
	);
	private $rules = array();

	function __construct() {
	}
	function setUploadDir( $dir ) {
		$rv = false;
		if ( is_dir(ROOT.$dir) ) {
			$rv = true;
			$this->uploadDir = $dir;
		} else {
			$result = mkdir( ROOT. $dir , 0777, true );
			$this->uploadDir = $dir;
			if ( ! $result ) {
				$rv = false;
			} else {
				$rv = true;
			}
		}
		return $rv;
	}
	function setPostName($postName) {
		$this->postName = $postName;
	}
	function setNamming( $rule ) {
		$rules = explode('+', $rule );
		foreach( $rules as $rule ) {
			if ( in_array( $rule, $this->availableRules ) {
				$this->rules[] = $rule;
			}
		}
	}
	function getNames() {
		if ( empty( $this->names ) ) {
			$this->setNames();
		}
		return $this->names;
	}
	private function setNames() {
		foreach( $_FILES as $file ) {
			$this->names = $this->getRand().$img_file1_name;
		}
	}
	function getRand() {
		mt_srand ((double) microtime() * 1000000);
		$randval = uniqid(mt_rand());
	}
	function upload() {
		if ( empty ( $this->uploadDir ) ) {
			return false;
		}
		$targetDir = ROOT . $this->uploadDir;
		if ( empty( $this->postName ) ) {
			$this->postName = array_pop( array_keys($_FILES) );
		}
		if ($_FILES[$this->postName]['error'] != UPLOAD_ERR_OK) {
			return false;
		}
		$name = $this->getUniqueName();
		$tmp_name = $_FILES[$this->postName]['tmp_name'];
		$result = move_uploaded_file($tmp_name, "$targetDir/$name");
		if ( $result == true ) {
			$this->flag = true;
			$this->fileInfo = $_FILES[$this->postName];
			$this->fileInfo['url'] = "/$this->uploadDir/$name";
		}
		return $this->flag;
	}
	private function getUniqueName() {
		$name = $_FILES[$this->postName]["name"];
		$sep =  explode( '.', $name );
		$this->ext = array_pop($sep);
		$realName = implode('.',$sep);
		$tempName = $realName;
		$i = 0 ;
		while( is_file( ROOT . $this->uploadDir . $tempName . '.' . $this->ext ) ){
			++$i;
			$tempName = $realName . '_' . $i;
		}
		return $tempName . '.' . $this->ext;
	}
	function isUpload() {
		return $this->flag;
	}
	function getUrl() {
		$rv = $this->fileInfo['url'];
		return $rv;
	}
	function getType() {
		return $this->fileInfo['type'];
	}
	function getExt() {
		return $this->ext;
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
}

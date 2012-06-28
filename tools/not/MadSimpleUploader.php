<?
// 이 툴은 항상 첫번째 file form을 upload한다.
class MadSimpleUploader {
	private $data;
	private $abs;

	function __construct( $dirName, $abs = false ) {
		$this->abs = $abs;
		$this->data = current($_FILES);
		$this->formName = key($_FILES);
		$this->setDir( $dirName );
		$this->upload();
	}
	function __get( $key ) {
		if ( isset($this->data[$key]) ) {
			return $this->data[$key];
		}
		return false;
	}
	function __set( $key, $value ) {
		$this->data[$key] = $value;
	}
	public function remove() {
		if ( is_file( $this->uploadFile ) ) {
			return unlink( $this->uploadFile );
		}
		return false;
	}
	public function test() {
		printR($this->data);
	}
	private function setDir( $dir ) {
		// 하위 호환성을 위해서 기본적으로 ROOT를 첨부.
		if ( $this->abs == false && strpos( $dir, ROOT ) !== 0 ) {
			$dir = ROOT . $dir;
		}
		if ( ! is_dir( $dir) ) {
			$result = mkdir( $dir , 0777, true );
		}
		$dir = realpath( $dir ) . '/';
		$this->uploadDir = $dir;
	}
	private function upload() {
		$this->uniqueName();
		$this->uploadFile = $this->uploadDir . $this->name;
		$this->src = '';
		if ( strpos( $this->uploadFile, ROOT ) === 0 ) {
			$this->src = substr( $this->uploadFile, strlen( ROOT ) - 1 );
		}
		$this->result = move_uploaded_file($this->tmp_name, $this->uploadDir."$this->name");
		$targetDir = $this->uploadDir;

		return $this;
	}
	private function uniqueName() {
		$sep =  explode( '.', $this->name );
		$this->ext = array_pop($sep);
		$tempName = $realName = implode('.',$sep);
		$i = 0 ;
		while( is_file( $this->uploadDir . $tempName . '.' . $this->ext ) ){
			++$i;
			$tempName = $realName . '_' . $i;
		}
		$this->name = $tempName . '.' . $this->ext;
	}
}

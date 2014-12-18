<?
class MadUploader extends MadFile {
	protected $dir = 'data';
	protected $data = array();
	protected $extensions = array();
	protected $prevents = array();
	protected $uploaders = array();

	function __construct( $data = array() ) {
		$this->data = $data;
	}
	function setData( $data ) {
		$this->data = $data;
		return $this;
	}
	function setExtensions( $extensions ) {
		$this->extensions = $extensions;
		return $this;
	}
	function setPrevents( $prevents ) {
		$this->prevents = $prevents;
		return $this;
	}
	function isAllow() {
		return $this->checkExtensions() && $this->checkPrevents();
	}
	function checkPrevents() {
		if ( empty( $this->prevents ) ) {
			return true;
		}
		return ! in_array( $this->getExt(), $this->prevents );
	}
	function checkExtensions() {
		if ( empty( $this->extensions ) ) {
			return true;
		}
		return in_array( $this->getExt(), $this->extensions );
	}
	function setDir( $dir ) {
		if ( ! is_dir( $dir ) ) {
			if( ! mkdir( $dir , 0777, true ) ) {
				throw new Exception( "fail to create dir: $dir" );
			}
		}
		$this->dir = $dir;
		return $this;
	}
	function upload() {
		$this->setFile( $this->getAvailableName() );
		$root = $_SERVER['DOCUMENT_ROOT'] . '/';
		if ( substr( $root, -1 ) === '/' ) {
			$root = substr( $root, 0, -1 );
		}
		if ( 0 === strpos( $this->file, $root ) ) {
			$this->src = substr( $this->file, strlen( $root ) );
		} else {
			$this->src = $this->file;
		}
		$this->result = move_uploaded_file( $this->tmp_name, $this->file );
		return $this->result;
	}
	function getExt() {
		if ( ! $this->ext ) {
			$this->setExt();
		}
		return $this->ext;
	}
	function setExt() {
		$explodeName = explode( '.', $this->name );
		$this->ext = array_pop( $explodeName );
		return $this;
	}
	private function getAvailableName() {
		$ext = $this->getExt();
		$name = baseName( $this->name, ".$ext" );
		$i = 0 ;
		$tail = '';
		while( is_file( $file = "$this->dir/$name$tail.$ext" ) ) {
			$tail = '_' . ++$i;
		}
		return $file;
	}
	// multi upload use self.
	function arrangeFileArray( $target ) {
		$target = $_FILES[$target];
		if ( is_array( $target['name'] ) ) {
			foreach( $target as $key => $row ) {
				foreach( $row as $no => $value ) {
					$this->data[$no][$key] = $value;
				}
			}
		} else {
			foreach( $target as $key => $value ) {
				$this->data[0][$key] = $value;
			}
		}
	}
	function uploadAll() {
		foreach( $this->files as $key => $row ) {
			if ( $row['error'] != 0 ) {
				$this->data[$key]['result'] = false;
				continue;
			}
			$this->input = $key;
			$this->data = $this->files[$key];
			$this->ext = $this->getExt( $this->name );
			$this->path = $this->getAvailableName( $this->dir . $this->name );
			$this->uploadedName = basename( $this->path );
			$this->src = substr( $this->path, strlen( ROOT ) - 1 );
			$this->result = move_uploaded_file( $row['tmp_name'], $this->path );
		}
		return $this->result;
	}
}

<?
// make this perfect.
// use CoC.
class MadUploader extends MadAbstractData {
	protected $dir = 'uploads';
	protected $data = array();
	protected $files = array();
	protected $uploaders = array();

	function __construct() {
	}
	function setDir( $dir ) {
		if ( ! is_dir( $dir ) ) {
			$result = mkdir( $dir , 0777, true );
		}
		$this->dir = realpath( $dir ) . '/';
		return $this;
	}
	function getTarget() {
		return $this->target;
	}
	function setTarget( $targets ) {
		if ( empty( $targets ) ) {
			$this->files = $_FILES;
			return $this;
		}
		if ( ! is_array( $targets ) ) {
			$targets = explode(',', $targets );
		} 
		foreach( $targets as $target ) {
			if ( isset( $_FILES[$target] ) ) {
				$this->uploaders[] = new MadUploader($target);
			}
		}
		$this->files = $target;
		return $this;
	}
	// not yet
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
	function getCount() {
		$rv = 0;
		foreach( $this->data as $key => $row ) {
			if ( $row['result'] ) {
				++$rv;
			}
		}
		return $rv;;
	}
	function upload() {
		$this->setExt();
		$this->path = $this->getAvailableName( $this->dir . $this->name );
		$this->uploadedName = basename( $this->path );
		$this->src = substr( $this->path, strlen( ROOT ) - 1 );
		$this->result = move_uploaded_file( $this->tmp_name, $this->path );
		return $this->result;
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
	function getResult() {
		return $this->result;
	}
	function getExt( $name ) {
		return array_pop(explode( '.', $name ));
	}
	function setExt() {
		$temp = explode( '.', $this->name );
		$this->ext = array_pop( $temp );
		return $this;
	}
	private function getAvailableName( $path ) {
		$sep =  explode( '.', $path );
		$ext = array_pop( $sep );
		$tempPath = $realPath = implode('.',$sep);
		$i = 0 ;
		while( is_file( $tempPath . '.' . $ext ) ) {
			++$i;
			$tempPath = $realPath . '_' . $i;
		}
		return $tempPath . '.' . $ext;
	}
}

<?
class FileUploader extends MadData {
	private $dir = 'uploads/';
	private $ext = '';

	function setDir( $dir ) {
		$this->dir = $dir;
		return $this;
	}
	function getDir() {
		return $this->dir;
	}
	function isDir() {
		return is_dir( $this->dir );
	}
	function upload( $target, $to='' ) {
		if ( ! isset( $_FILES[$target] ) ) {
			return $this;
		}
		$this->setData( $_FILES[$target] );

		if ( $this->error ) {
			return $this;
		}

		if ( ! empty( $to ) ) {
			$this->to = $to;
		}
		
		if ( empty( $this->to ) ) {
			$this->to = $this->dir . $this->name;
		}
		$this->to = $this->getUniqueFile( $this->to );
		$this->result = move_uploaded_file( $this->tmp_name, $this->to );
		return $this;
	}
	function isUpload() {
		return $this->result;
	}
	function remove() {
		if ( ! is_file( $this->to ) ) {
			return false;
		}
		return unlink( $this->to );
	}
	function getUniqueFile( $file ) {
		$dir = dirName( $file );

		$name = baseName( $file );
		$explode = explode( '.', $name );
		$this->ext = array_pop( $explode );
		$fileNameBody = implode( $explode );

		$i=1;
		while( is_file( $file ) ) {
			$file = "$dir/{$fileNameBody}_$i.$this->ext";
			++$i;
		}
		return $file;
	}
	// this is for muliple upload. not completed.
	private function getArrangedFiles( $target ) {
		$targetFiles = $_FILES[$target];
		$rv = array();
		foreach( $targetFiles as $key => $row ) {
			foreach( $row as $i => $value ) {
				if ( ! isset( $rv[$i] ) ) {
					$rv[$i] = array();
				}
				$rv[$i][$key] = $value;
			}
		}
		return $rv;
	}
	private function uploadSrcs( $item ) {
		$target = 'src';
		if ( ! isset( $_FILES[$target] ) ) {
			return false;
		}

		$files = new MadData( $this->getArrangedFiles( $target ) );

		$i = 1;
		foreach( $files as $file ) {
			$explode = explode('.', $file->name);
			$ext = end( $explode );
			$file->to = "data/src/px2/{$item->eventCode}_{$item->id}_$i.$ext";
			if ( ! $file->result = move_uploaded_file( $file->tmp_name, $file->to ) ) {
				return false;
			}
			++$i;
		}
		return $files;
	}
}

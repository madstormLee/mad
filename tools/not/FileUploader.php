<?
class FileUploader {
	public $path;
	public $fileName;
	public $fileNames;

	function __construct(){
		$this->path = '/mad/files/';
		$this->fileName = '';
	}
	function setPath($path) {
		$this->path = $path;
	}
	function setFileName($fileName) {
		$this->fileName = $fileName;
	}
	function upload($uploadId){
		if ( is_array($_FILES[$uploadId]['tmp_name']) ) {
			return $this->uploadMultiFiles($uploadId);
		}
		if ( ! is_file($_FILES[$uploadId]['tmp_name']) ) return false;
		$uploadPath = ROOT.$this->path;
		if(! is_dir($uploadPath)) mkdir($uploadPath,0777,true);

		$extensions = explode('.',$_FILES[$uploadId]['name']);
		$extLength = count($extensions);
		$extension = ( $extLength > 1 ) ? '.'.array_pop($extensions) : '';
		$fileName = implode('',$extensions);

		$this->fileName = empty($this->fileName) ? $fileName:$this->fileName.$extension;
		$destination = $uploadPath.'/'.$this->fileName.$extension;
		$fileName = $this->fileName.$extension;

		$num = 0;
		while (file_exists($destination)){     
			$num++;
			$fileName = $this->fileName.$num.$extension;
			$destination = $uploadPath.'/'.$fileName;
			if ( $num > 100 ) die;
		}
		move_uploaded_file($_FILES[$uploadId]['tmp_name'],$destination); 
		return $this->path.'/'.$fileName;
	}
	private function uploadMultiFiles($uploadId){
		$uploadedFileNumber = 0;
		$size = sizeof($_FILES[$uploadId]['name']);

		for($i=0; $i<$size; $i++){
			if ( ! is_file($_FILES[$uploadId]['tmp_name'][$i]) ) continue;
			$uploadPath = ROOT.$this->path;
			if(! is_dir($uploadPath)) mkdir($uploadPath,0777,true);

			$extension = explode('.',$_FILES[$uploadId]['name'][$i]);
			$extLength = count($extension);
			$extension = ( $extLength > 1 ) ? '.'.array_pop($extension) : '';
			$fileName = implode('',$extensions);

			$this->fileName = empty($this->fileName) ? $_FILES[$uploadId]['name'][$i] : $this->fileName.$extension;
			$destination = $uploadPath.'/'.$this->fileName.$extension;

			$num = 0;
			while (file_exists($destination)){     
				$num++;
				$fileName = $this->fileName.$num.$extension;
				$destination = $uploadPath.'/'.$fileName;
				if ( $num > 100 ) die;
			}
			$boolResult = move_uploaded_file($_FILES[$uploadId]['tmp_name'][$i],$destination); 
			if ( $boolResult ) $uploadedFileNumber++ ;
		}
		return $uploadedFileNumber;
	}
}

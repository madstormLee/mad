<?
class MadFile extends Mad {
	protected $fileInfo = null;
	protected $file = '';

	function __construct( $file = '' ) {
		parent::__construct();
		$this->setFile( $file );
	}
	function setFile( $file ) {
		$this->file = $file;
		if ( $this->existsFile() ) {
			$this->fileInfo = new SplFileInfo( $this->file );
		}
		return $this;
	}
	function getFile() {
		return $this->file;
	}
	function existsFile() {
		return file_exists($this->file);
	}
	function isFile() {
		return is_file($this->file);
	}
	function remove() {
		if( $this->isFile() ) {
			return unlink( $this->getViewPath() );
		}
		return false;
	}
	function getExtension() {
		return array_pop(explode( '.', $this->getFileName() ));
	}
	function __toString() {
		return 'tested';
	}
	function __call( $method, $args ) {
		if ( $this->fileInfo instanceof SplFileInfo ) {
			return call_user_func_array(
					array( $this->fileInfo, $method ),
					$args);
		} else {
			throw new Exception("There is no $method method in " . get_class($this) . "." );
		}
	}
}

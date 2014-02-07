<?
class MadFileData extends MadAbstractData {
	protected $file;
	function __construct( $file ) {
		$this->file = $file;
	}
	function setFile( $file ) {
		if ( ! empty( $file ) ) {
			$this->file = $file;
		}
		return $this;
	}
	function getFile() {
		return $this->file;
	}
	function isFile() {
		return is_file( $this->file );
	}
}

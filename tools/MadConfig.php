<?
class MadConfig extends MadJson {
	private $writeMode = 'force';

	function __construct( $fileName='' ) {
		parent::__construct( $fileName );
	}
	function setWriteMode( $writeMode ) {
		$this->writeMode = $writeMode;
		return $this;
	}
	function save() {
		if ( $this->writeMode == 'skip' && is_file( $targetFile ) ) {
			return false;
		}
		$this->setFile( $this->file );
		return parent::save();
	}
}

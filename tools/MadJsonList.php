<?
class MadJsonList extends MadFileList {
	function __construct( $dir = '' ) {
		parent::__construct( $dir );
		$this->setExt( 'json' );
	}
}

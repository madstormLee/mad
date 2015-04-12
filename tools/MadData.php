<?
class MadData extends MadAbstractData {
	function __construct( $data = array() ) {
		$this->setData( $data );
	}
	function fetch( $id ) {
		return $this->get( $id );
	}
}

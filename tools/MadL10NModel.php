<?
class MadL10NModel extends MadModel {
	function __construct( $id = '' ) {
		$this->db = MadDb::create();
		$this->db->setConnectInfo( MadL10N::getInstance()->db );
		parent::__construct( $id );
	}
}

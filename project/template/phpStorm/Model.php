<?
class {name} extends MadDbTable {
	function __construct() {
		parent::__construct();
	}
	function fetch( $no ) {
		return parent::fetch( $no );
	}
	function insert() {
		return parent::insert();
	}
	function update() {
		return parent::update();
	}
	function delete( $no ) {
		return parent::delete($no);
	}
}
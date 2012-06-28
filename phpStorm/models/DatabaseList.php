<?
class DatabaseList extends Mad implements MadFormalList {
	protected $data = array(); 
	protected $db; 

	function __construct( Database $db ) {
		$this->db = $db;
	}
	function isEmpty() {
		return empty( $this->data );
	}
	function setData() {
		$q = new ProjectQ("show databases");
		$this->data = $q->toArray();
	}
	function get() {
		if ( empty( $this->data ) ) {
			$this->setData();
		}
		return $this->data;
	}
	function getPageNavi() {
		return '';
	}
	function getIterator() {
		return new ArrayIterator( $this->get() );
	}
}

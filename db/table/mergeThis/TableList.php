<?
class TableList extends Mad implements MadFormalList {
	protected $data = array(); 
	protected $db; 

	function __construct( $db ) {
		parent::__construct();
		$this->db = $db;
	}
	function isEmpty() {
		return empty( $this->data );
	}
	function setData() {
		if ( empty( $this->db ) ) {
			$q = new ProjectQ("show tables");
		} else {
			$q = new ProjectQ("show tables in $this->db");
		}
		$this->data = $q->col();
		return $this;
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

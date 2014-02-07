<?
class Table {
	private $table;
	private $db;
	function __construct( $table='' ) {
		$this->table = $table;
		$this->db = MadDb::create();
	}
	function init() {
	}
	function getColumns() {
		$query = "SELECT * FROM information_schema.columns WHERE table_name ='$this->table'";
		return $this->db->query( $query )->getData();
	}
	function getTable() {
		return $this->table;
	}
}

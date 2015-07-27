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
	function getTableInfoIndex() {
		$query = new MadQuery( 'information_schema.tables' );
		$query->where("table_schema = 'itemshop'");
		$query->where("table_type like 'BASE TABLE'");
		$query->order('table_name');

		return $this->db->query( $query )->getData();
	}
	function getDbComment( $dbName ) {
		$query = "select description from pg_shdescription
		join pg_database on objoid = pg_database.oid
		where datname = '$dbName'";
	}
	function getPgTableComment() {
		$tableName = 'item';
		$schema = 'itemshop';

		$where[] =  "relname='$tableName'";
		if ( ! empty( $schema ) ) {
			$where[] =  "nspname='$schema'";
		}
		$where = 'where ' . implode( ' and ', $where );

		$query = "select *, description from pg_description
		join pg_class on pg_description.objoid = pg_class.oid
		join pg_namespace on pg_class.relnamespace = pg_namespace.oid
		$where
		";
		$query2 = "SELECT *, description
		FROM   pg_description
		WHERE  objoid = '$schema.$tableName'::regclass";

		$this->db->query( $query )->getData()->test();
		$this->db->query( $query2 )->getData()->test();
	}
}

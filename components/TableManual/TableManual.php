<?
class TableManual extends MadModel {
	protected $table = 'information_schema.tables';

	function __construct( $id ) {
		parent::__construct( $id );
	}

	function getDbComment( $dbName ) {
		$query = "select description from pg_shdescription
		join pg_database on objoid = pg_database.oid
		where datname = '$dbName'";
	}
	function getTableComment( $tableName, $schema='' ) {
		$where[] =  "relname='$tableName'";
		if ( ! empty( $schema ) ) {
			$where[] =  "nspname='$schema'";
		}
		$where = 'where ' . implode( ' and ', $where );

		print $query = "select *, description from pg_description
		join pg_class on pg_description.objoid = pg_class.oid
		join pg_namespace on pg_class.relnamespace = pg_namespace.oid
		$where
		";
		$query2 = "SELECT *, description
		FROM   pg_description
		WHERE  objoid = '$schema.$tableName'::regclass";
		$this->db->query( $query )->getData()->test();
		$this->db->query( $query2 )->getData()->test();
		die;
	}
	function getList( $where = '' ) {
		$query = new MadQuery( $this->table );
		$query->where( "table_type like 'BASE TABLE'" );
		if ( ! empty( $where ) ) {
			$query->where( $where );
		}
		$where = $query->getWhere();
		$query = "select * from $this->table $where order by table_name";
		return $this->db->query( $query )->getData();
	}
}

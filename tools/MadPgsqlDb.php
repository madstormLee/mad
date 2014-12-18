<?
class MadPgsqlDb extends MadDb {
	protected $schema = '';

	// override
	function setConnectInfo( $info ) {
		$this->conn->setConnectInfo( $info );
/* 		if ( ! empty( $info->schema ) && $this->conn ) {
			$this->exec( "set schema '$info->schema'" );
		}
 */		return $this;
	}
	function getConnectInfo() {
		return $this->conn->getConnectInfo();
	}
	function encoding( $encoding ) {
		return $this->query("set client_encoding to $encoding");
	}
	function indexes( $table ) {
		$query = "SELECT               
			pg_attribute.attname, 
			format_type(pg_attribute.atttypid, pg_attribute.atttypmod) 
				FROM pg_index, pg_class, pg_attribute 
				WHERE 
				pg_class.oid = '$table'::regclass AND
				indrelid = pg_class.oid AND
				pg_attribute.attrelid = pg_class.oid AND 
				pg_attribute.attnum = any(pg_index.indkey)
				AND indisprimary";
		return $this->query( $query );
	}
	function explain( $table ) {
		return $this->query( "SELECT * FROM information_schema.columns WHERE table_name = '$table'");
	}
	function getEmptyRow( $table ) {
		$rv = array();
		$q = self::explain( $table );
		return $q->getDictionary( 'Field', 'Default' );
	}
	function getTables( $table_schema = '', $table_type = 'BASE TABLE' ) {
		$where = array();
		if ( ! empty( $table_schema ) ) {
			$where[] = "table_schema like '$table_schema'";
		}
		if ( ! empty( $table_schema ) ) {
			$where[] = "table_type='$table_type'";
		}
		if ( ! empty( $where ) ) {
			$where = 'where ' . implode(' and ', $where );
		} else {
			$where = '';
		}
		$query = "SELECT * FROM information_schema.tables $where order by table_name";
		return $this->query( $query )  ;
	}
	function isTable( $table ) {
		return self::total("information_schema.tables", "table_name = '$table'");
	}
	function showColumns( $table ) {
		return $this->explain( $table )->getData()->dic('column_name');
	}
}

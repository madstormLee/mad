<?
class MadMysqlDb extends MadDb {
	function setConnect( $info ) {
		parent::setConnect( $info );
		self::$pdo->setAttribute( PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
	}
	function isTable($table_name){
		$query = "show tables like '%$table_name%'";
		return $this->query( $query )->rows();
	}
}

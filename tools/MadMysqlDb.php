<?
class MadMysqlDb extends MadDb {
	protected $driver = 'mysql';
	function __construct( $conn ) {
		$dsn = "mysql:host=$conn->host;dbname=$conn->dbname";
		$options = array(
			PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
			PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
		); 
		parent::__construct( $dsn, $conn->username, $conn->password, $options );
	}
	function isTable($table_name){
		$query = "show tables like '%$table_name%'";
		return $this->query( $query )->rows();
	}
	function explain( $table ) {
		$query = "explain $table";
		$this->query( $query );
		return $this->getData();
	}
	function escape( $value ) {
		if ( is_array( $value ) ) {
			return $this->escapeAll( $value );
		}
		if ( preg_match( '/now\(\)$/', $value ) ) {
			return $value;
		}
		$value = mysql_real_escape_string( $value );
		if ( false === strpos($value , '::') ) {
			return "'$value'";
		}
		$temp = explode( '::', $value );
		$temp[0] = "'$temp[0]'";
		return implode( '::', $temp );
	}
	function escapeField( $value ) {
		return  "`$value`";
	}
}

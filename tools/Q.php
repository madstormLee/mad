<?
class Q implements IteratorAggregate {
	const QUERY_FAILURE = 0;
	const QUERY_SUCCESS = 1;

	public static $conn_status = false;

	private $table;
	private $isError = true;
	private $result = false;
	private $rows=0, $fields;
	private $status = false;
	private $query = '';

	function __construct($query=''){
		if ( self::$conn_status == false ) {
			$this->conn();
		}
		if ( !empty( $query ) ) {
			$this->setQ($query);
		}
	}
	function __set($key, $value) {
	}
	function __call($key,$value) {
	}
	function __get($key) {
		if ( empty( $this->table ) ) {
			return false;
		}
		if ( empty( $this->result) ) $this->select();
		return $this->get($key);
	}
	function getIterator() {
		return new ArrayIterator( $this->toArray() );
	}
	function getResult() {
		return $this->result;
	}
	function getInsertId() {
		return mysql_insert_id();
	}
	function get($key) {
		return $this->query;
	}
	function rows() {
		return $this->rows;
	}
	static function getEmptyRow( $table ) {
		$rv = array();
		$query = "explain $table";
		$q = new Q($query);
		$tuple = $q->toArray();
		foreach( $tuple as $row ) {
			$rv[$row['Field']] = $row['Default'];
		}
		return $rv;
	}
	function excute(){
		$this->result = mysql_query($this->query);
		$command = $this->query->getCommand() ;
		if ( $this->result !== false ) {
			if ( $command == 'insert'
					or $command == 'update'
					or $command == 'delete') {
				$this->rows = mysql_affected_rows();
			} else if ($command == 'select' ) {
				$this->rows = mysql_num_rows();
			}
		}
	}
	function select() {
		$this->excute($query);
		if ( mysql_num_rows() == 1 ) {
			$this->row = mysql_fetch_assoc($this->result);
		}
	}
	function set($data='') {
		if ( blank($data) ) {
			return;
		} else if ( is_array($data) ) {
			$this->query->set(new MadSet($data));
		} else if ( is_string($data) ) {
			$parts = explode(' ', $data);
			if ( count($parts) == 1 ) {
				$table = $parts[0];
			}
			else if ( in_array($parts[0], $this->sqlStatement) ) {
				$this->parseQuery($data);
			}
		}
		$this->query = new MadQuery($table);
	}
	function conn() {
		$conn_file = MAD.'ini/conn.ini'; 
		if (!is_file($conn_file)) {
			return false;
		}
		$connInfo = parse_ini_file($conn_file);
		extract($connInfo);
		@mysql_connect($host,$id,$pw);
		return self::$conn_status = mysql_select_db($db);
	}
	function isTable() {
		return $this->table;
	}
	function isInTable($value, $fields='*') {
	}
	function setTable($tableName) {
		$this->table = $tableName;
	}
	function parseQuery($query) {
		$this->qeury = $query;
	}
	function setQ($query){
		$this->query = $query;
		$this->result = mysql_query($query);
		if ( ! $this->result ) {
			$this->isError = true;
			return false;
		}
		if( stripos($query, 'select') === 0 ) {
			$this->rows = mysql_num_rows($this->result);
			$this->fields=mysql_num_fields($this->result);
		}
		else $this->rows = mysql_affected_rows();
		$this->ckResult();
	}
	function isError() {
		return $this->isError;
	}
	function ckResult() {
		if ( ! $this->result ) {
			$message  = 'Invalid query: ' . mysql_error() . BR;
			$message .= 'Whole query: ' . $this->query . BR;;
			print $message;
		} else {
			return true;
		}
	}
	function toArray(){
		$rv = array();
		if ( $this->rows() > 0 ) {
			while ( $row = mysql_fetch_assoc($this->result) ) {
				$rv[] = $row;
			}
		}
		return $rv;
	}
	function toIndexArray( $indexField ){
		$rv = array();
		if ( $this->rows() > 0 ) {
			while ( $row = mysql_fetch_assoc($this->result) ) {
				$rv[$row[$indexField]] = $row;
			}
		}
		return $rv;
	}
	function toObject(){
		$rv = array();
		if ( $this->rows() > 0 ) {
			while ( $row = mysql_fetch_object($this->result) ) {
				$rv[] = $row;
			}
		}
		return $rv;
	}
	function toDictionary(){
		$rv = array();
		if ( $this->rows() > 0 ) {
			while ( $row = mysql_fetch_row($this->result) ) {
				$rv[$row[0]] = $row[1];
			}
		}
		return $rv;
	}
	function row() {
		$rv = array();
		if ( $this->rows > 0 ) {
			$rv = mysql_fetch_assoc($this->result);
		}
		return $rv;
	}
	function rowObject() {
		$rv = new Object;
		if ( $this->rows > 0 ) {
			$rv = mysql_fetch_object($this->result);
		}
		return $rv;
	}
	function col() {
		$rv = array();
		while ( $row = $this->row() ) {
			$rv[] = array_shift($row);
		}
		return $rv;
	}
	function getColumn( $fieldName ) {
		$rv = array();
		if ( $this->rows() > 0 ) {
			while ( $row = mysql_fetch_assoc($this->result) ) {
				$rv[] = $row[$fieldName];
			}
		}
		return $rv;
	}
	function getFirst() {
		if ( $this->result ) {
			return array_pop($this->row());
		} else {
			return false;
		}
	}
	static function total($from, $where='') {
		$where = trim($where);
		if ( ! empty ( $where ) ) {
			$where = str_ireplace( 'where', '', $where );
			$where = 'where '.$where;
		}
		if ( ! empty ( $from ) ) {
			$from = preg_replace( '/from/i', '', $from, 1 );
			$from = ' from '.$from;
		}

		$query = "select count(*) $from $where";
		$q = new Q($query);
		if( $q->rows() < 1 ) {
			return 0;
		} else {
			return $q->getFirst();
		}
	}
	static function max($table, $field, $where = '') {
		if ( ! empty ( $where ) ) {
			$where = str_ireplace( 'where', '', $where );
			$where = 'where '.$where;
		}
		$query = "select max($field) from $table $where";
		$q = new Q($query);
		$rv = $q->getFirst();
		if( $rv == NULL ) {
			return 0;
		}
		return $rv;;
	}
	static function explain( $table ) {
		$q = new Q("explain $table");
		return $q->toArray();
	}
	static function truncate( $table ) {
		$q = new Q("truncate $table");
		return $q->rows();
	}
	function test() {
		printR($this->toArray());
	}
	function __toString() {
		return $this->query;
	}
}

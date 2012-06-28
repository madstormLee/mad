<?
class MadQ extends MadData {
	const QUERY_FAILURE = 0;
	const QUERY_SUCCESS = 1;

	private $table = '';
	private $select = '*';
	private $where;
	private $group;
	private $limit;

	function __construct( $table = '' ) {
		$this->where = new MadWhere;
		$this->order = new MadOrder;
		$this->limit = new MadLimit;

		if ( ! empty( $table ) ) {
			$this->table = $table;
		}
	}
	function setTable( $table ) {
		$this->table = $table;
	}
	function select() {
		$query = "select $this->select from $this->table $this->where $this->order $this->limit";
		$q = new Q($query);
		$this->data = $q->toArray();
	}
	function insert() {
		$query = "insert into $this->table $this->set";
	}
	function update() {
		$query = "update $this->table $this->set $this->where $this->limit";
	}
	function truncate() {
		$query = "truncate $this->table";
	}
	function create() {
		$repos = new MadRepository('config');
		$installer = new MadAutoInstaller;
		if ( $repos->schemeDirs ) {
			foreach( $repos->schemeDirs as $dir ) {
				if ( is_file( $scheme = $dir . $this->table . '.sql' ) ) {
					$installer->installScheme( $scheme );
				}
			}
		}
		return $installer->isInstalled();
	}
	function drop() {
		$query = "drop table $this->table";
	}
	function getMax($field) {
		$query = "select max($field) from $this->table";
		$q = new Q($query);
		if( $q->rows() < 1 ) {
			return 0;
		} else {
			return $q->getFirst();
		}
	}
	function getTotal($where='') {
		$where = trim($where);
		if ( ! empty ( $where ) ) {
			$where = str_ireplace( 'where', '', $where );
			$where = 'where '.$where;
		}

		$query = "select count(*) $this->table $where";
		$q = new Q($query);
		if( $q->rows() < 1 ) {
			return 0;
		} else {
			return $q->getFirst();
		}
	}
	function query( $query ) {
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



	function getQuery() {
		return $this->query;
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
	function parseQuery($query) {
		$this->qeury = $query;
	}
	function setQ($query){
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
		} else {
			$query = 'explain t_article2';
			$result = mysql_query($query);
			while( $row = @mysql_fetch_assoc($result) ) {
				$rv[$row['Field']] = '';
			}
		}
		return $rv;
	}
	function col() {
		$this->select();
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
	function test() {
		printR($this->toArray());
	}
}

<?
class MadQ implements IteratorAggregate {
	protected $query = '';
	protected $result = null;
	protected $data = null;
	protected $dbh = null;

	function __construct( $query = '' ) {
		$this->dbh = MadDbConnect::getPDO();
		if ( !empty( $query ) ) {
			$this->query($query);
		}
	}
	function getIterator() {
		return $this->data;
	}
	function getInsertId() {
		return $this->dbh->lastInsertId();
	}
	function query( $query ){
		$this->query = $query;
		$this->result = $this->dbh->query( $query );
		return $this->result;
	}
	function getRows() {
		if ( ! $this->result ) {
			return 0;
		}
		return $this->result->rowCount();
	}
	function rows() {
		if ( ! $this->result ) {
			return 0;
		}
		return $this->result->rowCount();
	}
	function setData( $data = array() ) {
		$this->data = $data;
		return $this;
	}
	function getAllColumnMeta() {
		$rv = array();
		for( $i = 0; $i < $this->result->columnCount(); ++$i ) {
			$rv[] = $this->result->getColumnMeta( $i );
		}
		return $rv;
	}
	function toArray() {
		$this->result->setFetchMode(PDO::FETCH_ASSOC);
		return $this->result->fetchAll();
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
	function toObject( $object = 'stdClass' ) {
		if( is_object( $object ) ) {
			$object = get_class( $object );
		}
		$object = 'stdClass';
		$rv = array();
		while( $row = $this->result->fetchObject( $object ) ) {
			$rv[] = $row;
		}
		$this->data = new MadData( $rv );
		return $this;
	}
	function toDictionary() {
		if ( $this->rows() > 0 ) {
			foreach( $this as $row ) {
				$rv[$row[0]] = $row[1];
			}
		}
		return $rv;
	}
	function getDictionary( $key = '', $value = '' ) {
		$rv = array();
		foreach( $this->result->toObject() as $row ) {
			$rv[$row->$key] = $row->$value;
		}
		return $rv;
	}
	/******************* fetches *******************/
	function fetch() {
		return $this->result->fetch( PDO::FETCH_ASSOC );
	}
	function fetchAssoc() {
		return $this->result->fetch( PDO::FETCH_ASSOC );
	}
	function fetchObject( $object ) {
		return $this->result->fetchObject();
	}
	function row() {
		return $this->result->fetch( PDO::FETCH_ASSOC );
	}
	function rowObject() {
		return $this->result->fetchObject();
	}
	function col() {
		$rv = array();
		while ( $col = $this->result->fetchColumn() ) {
			$rv[] = $col;
		}
		return $rv;
	}
	function getColumn( $fieldName ) {
		$rv = array();
		if ( $this->rows() > 0 ) {
			foreach( $this->toObject() as $row ) {
				$rv[] = $row->$fieldName;
			}
		}
		return $rv;
	}
	function getFirst() {
		if ( $this->result ) {
			return array_pop( $this->row() );
		} else {
			return false;
		}
	}
	/**************** static methods *********************/
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
		$q = new self( $query );
		return ( $q->rows() < 1 ) ? 0 : $q->getFirst();
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
		return  new self("explain $table");
	}
	static function truncate( $table ) {
		$q = new self("truncate $table");
		return $q->rows();
	}
	// 아직 잘 모르겠음.
	static function getEmptyRow( $table ) {
		$rv = array();
		$q = new self("explain $table");
		return $q->getDictionary( 'Field', 'Default' );
	}
	/***************** utilities ********************/
	function test() {
		printR( $this->result );
	}
	/***************** magic methods ******************/
	function __set($key, $value) {
	}
	function __call($key,$value) {
	}
	function __get($key) {
	}
	function __toString() {
		return $this->query;
	}
}

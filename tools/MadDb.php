<?
class MadDb extends PDO implements IteratorAggregate, Countable {
	protected $defaultDriver = 'mysql';
	protected $driver = 'mysql';

	protected $data = array();
	protected $rows = 0;
	protected $statement = null;

	// factory method
	static function create( $conn = null ) {
		if ( $conn == null ) {
			$conn = MadConfig::getInstance()->database;
		}
		if ( is_null($conn) ) {
			throw new Exception( 'Connection info not found.' );
		}

		$dsn = "mysql:host=$conn->host;dbname=$conn->dbname";
		$options = array();
		foreach( $conn->options as $key => $value ) {
			$options[(int)$key] = $value;
		}

		$db = new self( $dsn, $conn->username, $conn->password, $options );
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return $db;
	}
	function query( $query ) {
		$this->statement = parent::query( $query );
		return $this;
	}
	function setData( $data ) {
		$this->data->setData( $data );
		return $this;
	}
	function getData() {
		return $this->data = $this->statement->fetchAll();
	}
	/******************* fetches *******************/
	function fetch( $class = 'StdClass' ) {
		$this->statement->setFetchMode( PDO::FETCH_CLASS, $class );
		return $this->statement->fetch();
	}
	function fetchAssoc() {
		return $this->statement->fetch( PDO::FETCH_ASSOC );
	}
	function row() {
		return $this->fetch();
	}
	function fetchColumn( $fieldName ) {
		$rv = array();
		foreach( $this->data as $row ) {
			$rv[] = $row->$fieldName;
		}
		return new MadData( $rv );
	}
	function getFirst() {
		if ( empty( $this->data ) ) {
			return false;
		}
		$rv = current( $this->data[0] );
		return $rv;
	}
	/*********************** utilities ***********************/
	function rows() {
		return $this->statement->rowCount();
	}
	function count() {
		return $this->statement->rowCount();
	}
	function getAllColumnMeta() {
		$rv = array();
		for( $i = 0; $i < $this->result->columnCount(); ++$i ) {
			$rv[] = $this->result->getColumnMeta( $i );
		}
		return $rv;
	}
	/******************* getter only ******************/
	function getStatement() {
		return $this->statement;
	}
	function getInsertId( $key = '' ) {
		return $this->lastInsertId( $key );
	}
	function getIterator() {
		return $this->getData();
	}
	/***************** utilities ********************/
	function total( $from, $where='' ) {
		$where = trim($where);
		if ( ! empty ( $where ) ) {
			$where = str_ireplace( 'where', '', $where );
			$where = 'where '.$where;
		}
		if ( ! empty ( $from ) ) {
			$from = preg_replace( '/from/i', '', $from, 1 );
			$from = ' from '.$from;
		}

		$rv = $this->query("select count(*) $from $where")->getFirst();
		return ( $rv ) ? $rv : 0;
	}
	function max($table, $field, $where = '') {
		if ( ! empty ( $where ) ) {
			$where = str_ireplace( 'where', '', $where );
			$where = 'where '.$where;
		}
		$query = "select max($field) from $table $where";
		$q = new self($query);
		$rv = $q->getFirst();
		if( ! $rv ) {
			return 0;
		}
		return $rv;;
	}
	function truncate( $table ) {
		return $this->query("truncate $table");
	}
	function clear() {
		$this->data = array();
		return $this;
	}
	function setDebug( $debug ) {
		$this->debug = ! ! $debug;
		if ( $this->debug === true ) {
		}
		return $this;
	}
	static function testColumns( $table ) {
		self::create()->showColumns( $table )->test();
	}
	/***************** magic methods ******************/
	function __unset( $key ) {
		unset( $this->data->$key );
	}
	function __toString() {
		// this must view db spec
		return $this->query;
	}
	/***************** escapes ******************/
	public function escapeFields( $data ) {
		foreach( $data as &$value ) {
			$value = $this->escapeField( $value );
		}
		return $data;
	}
	public function escapeField( $value ) {
		if ( is_array( $value ) ) {
			return $this->escapeFields( $value );
		}
		if ( false !== strpos( '.', $value ) ) {
			$fields = explode( '.', $value );
			return implode( '.', $this->escapeFields( $fields ) );
		}
		if ( $this->driver == 'mysql' ) {
			return  "`$value`";
		}
		return "\"$value\"";
	}
	public final function getSet( $data ) {
		$rv = array();
		foreach( $data as $key => $value ) {
			$rv[] = $this->escapeField( $key ) . "=:$key";
		}
		return implode( ', ', $rv );
	}
}

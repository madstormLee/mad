<?
class MadDb implements IteratorAggregate, Countable {
	protected static $supportDrivers = array(
			'pgsql' => 'MadPgsqlDb',
			'mysql' => 'MadMysqlDb',
			);
	protected $defaultDriver = 'pgsql';

	protected $conn = null;

	protected $index = false;
	protected $query = '';

	protected $data = array();
	protected $rows = 0;
	protected $result = null;

	function __construct( $query = '' ) {
		$this->conn = new MadDbConn;

		if ( ! empty( $query ) ) {
			$this->query( $query );
		}
	}
	// factory method pattern?
	static function create( $conn = null ) {
		if ( empty( $conn ) || isset( self::$supportDrivers[$name] ) ) {
			return new $this->defaultDriver;
		}
		$driver = self::$supportDrivers[$conn->server];

		$db = new $driver;
		return $db->setConnectInfo( $conn );
	}
	function setDatabase( $name ) {
		$databases = MadGlobals::getInstance()->databases;
		$connectInfo = $databases->$name;
		if ( ! $connectInfo  ) {
			$connectInfo = $databases->default;
		}
		$this->setConnectInfo( $connectInfo );
		return $this;
	}
	function setDebug( $debug = true ) {
		$this->conn->setDebug( true );
		return $this;
	}
	function exec( $query ) {
		return $this->conn->exec( $query ) ;
	}
	function query( $query, $class = '' ) {
		$this->query = $query;

		if ( ! $this->result = $this->conn->query( $query ) ) {
			return $this;
		}

		if ( ! empty( $class ) ) {
			$this->result->setFetchMode( PDO::FETCH_CLASS);
		} else {
			$this->result->setFetchMode( PDO::FETCH_OBJ);
		}
		$data = $this->result->fetchAll();

		$this->data = array();
		foreach( $data as &$row ) {
			if ( $this->index && isset( $row->{$this->index} ) ) {
				$key = $row->{$this->index};
				$this->data[$key] = $row;
			} else {
				$this->data[] = $row;
			}
		}

		if ( preg_match( '/^select/i', $this->query ) ) {
			$this->rows = count( $this->data );
		} else {
			$this->rows = $this->result->rowCount();
		}

		return $this;
	}
	function getKeys() {
		return new MadData( array_keys( $this->data ) );
	}
	function setData( $data ) {
		$this->data->setData( $data );
		return $this;
	}
	function getData() {
		$rv = new MadData( $this->data );
		$this->clear();
		return $rv;
	}
	function setConnectInfo( $conn ) {
		$this->conn->setConnectInfo( $conn );
		return $this;
	}
	function index( $index ) {
		$this->index = $index;
		return $this;
	}
	/******************* fetches *******************/
	function fetch() {
		return current( $this->data );
	}
	function row() {
		return $this->fetch();
	}
	function fetchColumn( $fieldName ) {
		$rv = array();
		foreach( $this as $row ) {
			$rv[] = $row->$fieldName;
		}
		return new MadData( $rv );
	}
	function getFirst() {
		if ( empty( $this->data ) ) {
			return false;
		}
		$rv = current( $this->data[0] );
		$this->clear();
		return $rv;
	}
	/*********************** utilities ***********************/
	function rows() {
		return $this->rows;
	}
	function count() {
		return $this->rows();
	}
	function getAllColumnMeta() {
		$rv = array();
		for( $i = 0; $i < $this->result->columnCount(); ++$i ) {
			$rv[] = $this->result->getColumnMeta( $i );
		}
		return $rv;
	}
	function dic( $target1 = '', $target2='' ) {
		return $this->getData()->dic( $target1, $target2 );
	}
	function getDictionary( $key = '', $value = '' ) {
		$rv = array();
		foreach( $this->data as $row ) {
			$rv[$row->$key] = $row->$value;
		}
		return new MadData( $rv );
	}
	/******************* getter only ******************/
	function getResult() {
		return $this->result;
	}
	function getInsertId( $key = '' ) {
		return $this->conn->getInsertId( $key );
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
	static function testColumns( $table ) {
		self::create()->showColumns( $table )->test();
	}
	function test() {
		print $this->query;
		print BR;
		(new MadDebug)->printR( $this->data );
	}
	/***************** magic methods ******************/
	function __unset( $key ) {
		unset( $this->data->$key );
	}
	function __toString() {
		return $this->query;
	}
}

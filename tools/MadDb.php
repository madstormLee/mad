<?
class MadDb extends PDO implements IteratorAggregate, Countable {
	protected $defaultDriver = 'mysql';
	protected $driver = 'mysql';

	protected $data = array();
	protected $rows = 0;
	protected $statement = null;

	// factory method
	public static function create( $conn = null ) {
		if ( $conn == null ) {
			return MadConfig::getInstance()->db;
		}
		if ( is_null($conn) ) {
			throw new Exception( 'Connection info not found.' );
		}
		return new self( $conn );
	}
	private static $defaultConn = null;
	private static $connections = array();

	static function addConnections( $id, PDO $pdo ) {
		self::$connections[$id] = $pdo;
	}

	static function setDefaultConn( $conn ) {
		self::$defaultConn = $conn;
	}
	static function getConn() {
		if ( ! is_null( self::$pdo ) ) {
			return self::$pdo;
		}
		if ( ! is_file( self::$iniFile ) ) {
			throw new Exception("DBConnectFile does not exist.");
		}
		$ini = new MadIni( self::$iniFile );
		$info = $ini->database;
		return self::create( $info );
	}
	function __construct( $conn = null ) {
		if ( is_string( $conn ) ) {
			$dsn = $conn;
			return parent::__construct( $conn );
		}
		$options = $this->getOptions( $conn->options );
		parent::__construct( $this->getDsn($conn), $conn->username, $conn->password, $options );

		$this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}
	function query( $query ) {
		$this->statement = parent::query($query);
		return $this->statement;
	}
	function getOptions( $options ) {
		if ( ! ( is_array( $options ) || is_object( $options ) ) ) {
			return false;
		}
		$rv = array();
		foreach( $options as $key => $value ) {
			$rv[(int)$key] = $value;
		}
	}
	function getDsn( $info ) {
		return "$info->driver:host=$info->host;port=$info->port;dbname=$info->db";
	}
	function setData( $data ) {
		$this->data->setData( $data );
		return $this;
	}
	function getData() {
		return $this->data = $this->statement->fetchAll();
	}
	/******************* fetches *******************/
	function fetchObject( $class = 'StdClass' ) {
		$this->statement->setFetchMode( PDO::FETCH_CLASS, $class );
		return $this->statement->fetch();
	}
	function fetch( $class='StdClass', $type=0  ) {
		if ( empty( $type ) ) {
			return $this->fetchObject( $class );
		}
		return parent::fetch( $type );
	}
	function fetchAssoc() {
		return $this->statement->fetch( PDO::FETCH_ASSOC );
	}
	function fetchAll( $class=null) {
		if ( is_null( $class ) ) {
			return $this->statement->fetchAll( PDO::FETCH_ASSOC );
		}
		return $this->statement->fetchAll( PDO::FETCH_CLASS, get_class($class) );
	}
	function row() {
		return $this->fetch();
	}
	function getFirst() {
		if ( ! $this->statement ) {
			return false;
		}
		$row = $this->fetchAssoc();
		return current( $row );
	}
	/*********************** utilities ***********************/
	function count() {
		if ( ! $this->statement ) {
			return 0;
		}
		return $this->statement->rowCount();
	}
	function rows() {
		return $this->count();
	}
	function getRows() {
		return $this->count();
	}
	function getAllColumnMeta() {
		$rv = array();
		for( $i = 0; $i < $this->statement->columnCount(); ++$i ) {
			$rv[] = $this->statement->getColumnMeta( $i );
		}
		return new MadData($rv);
	}
	/******************* getter only ******************/
	function getStatement() {
		return $this->statement;
	}
	function getInsertId( $key = '' ) {
		return $this->lastInsertId( $key );
	}
	function getIterator() {
		return new ArrayIterator($this->getData());
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
	function setDebug( $debug ) {
		$this->debug = ! ! $debug;
		if ( $this->debug === true ) {
		}
		return $this;
	}
	function __toString() {
		return $this->statement->queryString;
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

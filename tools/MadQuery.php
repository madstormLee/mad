<?
class MadQuery implements IteratorAggregate, Countable {
	protected $server = 'mysql';
 	protected $db = null;
	protected $command = 'select';
 	protected $table = '';
 	protected $tables = array();
	protected $select = '*';
	protected $having = array();
	protected $where = array();
	protected $order = array();
	public $limit = '10';
	protected $offset = 0;

	protected $on = array();
	protected $group;

	protected $rollback = false;
	protected $rollbackQuery = '';

	protected $data = array();
	protected $count = 0;

	protected $model = null;
	protected $statement;

	protected $pKey = 'id';

	function __construct( $table = '' ) {
		$this->from( $table );
	}
	function getCommand() {
		return $this->command;
	}
	/*************************** setters *************************/
	/******************** commands ********************/
	function select( $select='*' ) {
		$this->command = 'select';
		if ( is_array( $select ) ) {
			$select = implode( ',', $select );
		}
		$this->select = $select;
		return $this;
	}
	function insert( $data ) {
		$this->command = 'insert';
		$this->data = $data;
		return $this;
	}
	function update( $data ) {
		$this->command = 'update';
		$this->data = $data;
		return $this;
	}
	function delete( $where='' ) {
		if ( ! empty( $where ) ) {
			$this->where( $where );
		}
		$this->command = 'delete';
		return $this;
	}
	function result() {
		return $this->exec();
	}
	function from( $table = '' ) {
		$this->table = $table;
		if ( empty( $table ) ) {
			$this->tables = array();
		} else {
			$this->tables[] = $table;
		}
		return $this;
	}
	function into( $table ) {
		return $this->from( $table );
	}
	function innerJoin( $table ) {
		$this->table[] = array(
			'inner join' => $table
		);
		return $this;
	}
	function leftJoin( $table ) {
		$this->table[] = array(
			'left join' => $table
		);
		return $this;
	}
	function on( $on ) {
		$this->on[] = $on;
		return $this;
	}
	function where( $where = '' ) {
		if ( empty( $where ) ) {
			$this->where = array();
		} else {
			if ( strpos( $where,  '=' ) ) {
				list($key, $value) = explode('=', $where);
				$this->data[$key] = $value;
				$this->where[] = "$key=:$key";
			} else {
				$this->where[] = $where;
			}
		}
		return $this;
	}
	function having( $having = '' ) {
		if ( empty( $having ) ) {
			$this->having = array();
		} else {
			$this->having[] = $having;
		}
		return $this;
	}
	function order( $order = '' ) {
		if ( empty( $order ) ) {
			$this->order = array();
		} else {
			$this->order[] = $order;
		}
		return $this;
	}
	function group( $column = '' ) {
		if ( empty( $group ) ) {
			$this->group = array();
		} else {
			$this->group[] = $column;
		}
		return $this;
	}
	function page( $page ) {
		$this->page = $page;
	}
	function limit( $limit = '', $page = 1 ) {
		if ( $limit > 0 ) {
			$this->limit = $limit;
		} else {
			$this->limit = 0;
		}
		if ( $page > 1 ) {
			$this->offset = ( $page - 1) * $this->limit;
		}
		// convention
		$page = 1;
		if ( ! $page = ckKey('page', $_GET) ) {
			$page = 1;
		}
		$this->offset = ( $page -1 ) * $this->limit;
		return $this;
	}
	function offset( $offset ) {
		$this->offset = $offset;
		return $this;
	}
	/*************************** db involed ***************************/
 	function query( $query = '' ) {
 		if ( ! $query ) {
 			$query = $this->getQuery();
 		}
 		$this->statement = $this->getDb()->prepare( $query );
		if ( ! $this->statement->execute( $this->data ) ) {
			throw new Exception('query error!');
		}
 		return $this;
 	}
 	function exec( $query = '' ) {
 		if ( ! $query ) {
 			$query = $this->getQuery();
 		}
		$statement = $this->getDb()->prepare( $query );
		if ( ! $this->statement->execute( $this->data ) ) {
			throw new Exception('query error!');
		}

		if ( $this->command == 'insert' ) {
			return $statement->getInsertId();
		}
		return $statement->rowCount();
 	}
	/************************* getter/setter **************************/
	function getDb() {
		if ( is_null( $this->db ) ) {
			$this->setDb();
		}
		return $this->db;
	}
	function setDb( PDO $db=null ) {
		if ( is_null($db) ) {
			$db = MadDb::create();
		}
		$this->db = $db;
		return $this;
	}
	function getModel() {
		if ( is_null( $this->model ) ) {
			$this->setModel();
		}
		return $this->model;
	}
	function setModel(MadData $model=null) {
		if ( is_null( $this->model ) ) {
			$model = new MadData;
		}
		$this->model = $model;
		return $this;
	}
	function getFrom() {
		return $this->table;
		return $this->getDb()->escapeField( $this->table );
		return implode( ' inner join ', $table );
	}
	function getOn() {
		if ( empty( $this->on ) ) {
			return '';
		}
		$on = implode( ' and ', $this->on );
		return "on $on";
	}
	function getWhere() {
		if ( empty( $this->where ) ) {
			return '';
		}
		$where = array();
		foreach( $where as $value ) {
			list( $field, $value ) = explode( '=', $value );
			$where[] = $this->escape( $value );
		}
		return 'where ' . implode( ' and ', $this->where );
	}
	function getHaving() {
		if ( empty( $this->having ) ) {
			return '';
		}
		return 'having ' . implode( ' and ', $this->having );
	}
	function setOrder( $order ) {
		$this->order = array();
		return $this->order( $order );
	}
	function getOrder() {
		if ( empty( $this->order ) ) {
			return '';
		}
		return 'order by ' . implode( ',', $this->order );
	}
	function getLimit() {
		if ( empty( $this->limit ) ) {
			return '';
		}
		return "limit $this->limit offset $this->offset";
	}
	/************************** queries ************************/
	function getQuery() {
		$action = 'get' . ucFirst( $this->command ) . 'Query';
		return (string)$this->$action();
	}
	function getSelectQuery() {
		$from = $this->getFrom();
		$on = $this->getOn();
		$where = $this->getWhere();
		$having = $this->getHaving();
		$order = $this->getOrder();
		$limit = $this->getLimit();
		return "select $this->select from $from $on $where $order $limit";
	}
	function getInsertQuery() {
		$table = $this->getDb()->escapeField( $this->table );
		$fields = $this->getFields();
		$placeholder = $this->getPlaceholders();
		return "insert into $table ($fields) values ($placeholder)";
	}
	function getUpdateQuery() {
		$set = $this->data;
		if ( ! $key = ckKey( $this->pKey, $set ) ) {
			return false;
		}
		$set = $this->getSet();
		$where = $this->getWhere();
		return "update `$this->table` set $set $where";
	}
	function getDeleteQuery() {
		$where = $this->getWhere();
		return "delete from `$this->table` $where";
	}
	// this is not right.
	function __get( $key ) {
		$method = 'get' . ucfirst( $key );
		if ( method_exists( $this, $method ) ) {
			return $this->$method();
		}
		return '';
	}
	function __set( $key, $value ) {
		$this->data[$key] = $value;
	}
	function __toString() {
		return $this->getQuery();
	}
	/******************* implementaion *****************/
	function getIterator() {
		if ( empty( $this->statement ) ) {
			$this->query();
			$this->statement = $this->getDb()->getStatement();
			$this->statement->setFetchMode( PDO::FETCH_CLASS, $this->model );
		}
		return new ArrayIterator( $this->statement->fetchAll() );
	}
	function count() {
		return count( $this->data );
	}
	/******************* getter/setter *****************/
	function data() {
		return $this->data;
	}
	function setData( $data ) {
		$this->data = $data;
		return $this;
	}
	/****************** fetches *****************/
	function row() {
		return $this->fetch();
	}
	function fetchAssoc() {
		$this->query();
		return $this->statement->fetch(PDO::FETCH_ASSOC);
	}
	function fetch() {
		$this->query();
		$this->statement->setFetchMode( PDO::FETCH_INTO, $this->getModel() );
		return $this->statement->fetch();
	}
	function fetchObject( $class = '' ) {
		$this->query();
		return current( $this->data );
		// return $this->query()->fetchObject( $class );
	}
	function insertId() {
		return $this->query()->getInsertId();
	}
	function rows() {
		return $this->query()->getRows();
	}
	/*************************** test ***************************/
	function isEmpty() {
		return empty( $this->data );
	}
	function getDriver() {
		return $this->getDb()->getAttribute(PDO::ATTR_DRIVER_NAME);
	}
	function isTable(){
		$driver = $this->getDriver();
		if ( $driver == 'sqlite' ) {
			$query = "select name from sqlite_master where type='table' AND name='$this->table'";
		} elseif ( $driver == 'mysql' ) {
			$query = "show tables like '$this->table'";
		}
		$result = $this->getDb()->query( $query )->fetch();
		return ! empty( $result );
	}
	/*************************** utilities ***************************/
	function getFields() {
		$set = $this->data;
		unset( $set[$this->pKey] );

		$keys = array_keys( $set );
		return implode( ',', $this->getDb()->escapeFields( $keys ) );
	}
	function getPlaceholders() {
		$rv = array();
		foreach( $this->data as $key => $value ) {
			$rv[] = ':' . $key;
		}
		return implode(',', $rv );
	}
	function getSet() {
		$rv = array();
		foreach( $this->data as $key => $value ) {
			if ( $key == $this->pKey ) {
				$this->where( "id=$value" );
			}
			$rv[] = "$key=:$key";
		}
		return implode(', ', $rv );
	}
	function total( $where='' ) {
		$where = $this->formatWhere( $where );
		$query = new MadQuery( $this->table );
		return $query->select('count(*)')->where( $where )->fetch()->first();
	}
	function searchTotal() {
		return $this->total( $this->getWhere() );
	}
	function formatWhere( $where ) {
		$where = trim( $where );
		return empty($where)? '' : 'where ' . str_ireplace( 'where', '', $where );
	}
	function max($field='id', $where='') {
		$where = $this->formatWhere( $where );
		$query = "select max($field) from $this->table $where";
		return $this->getDb()->query( $query )->getFirst();
	}
	function drop() {
		return $this->getDb()->exec("drop table $this->table");
	}
	function truncate() {
		return $this->getDb()->exec( "truncate $this->table" );
	}
	function explain() {
		return $this->getDb()->query( "explain $this->table" )->getData();
	}
	function getDefaults() {
		$data = new MadData( $this->explain() );
		return $data->dic( 'Field', 'Default' );
	}
	/************************ todo: refactorying. from MadDbModel ************************/
	function getNextId() {
		$query = "select min( $this->pKey ) from $this->table where $this->pKey > $this->id";
		return $this->getDb()->query( $query )->getFirst();
	}
	function getPrevId() {
		$query = "select max( $this->pKey ) from $this->table where $this->pKey < $this->id";
		return $this->getDb()->query( $query )->getFirst();
	}
	/**************************** query and rollback ****************************/
	public function setRollback( $flag = true ) {
		$this->rollback = $flag;
		return $this;
	}
	public function getRollback() {
		$this->rollback = $flag;
		return $this;
	}
	public function rollback() {
		return $this->getDb()->exec( $this->rollbackQuery );
	}
	function createRollback() {
		if ( ! $this->rollback ) {
			return false;
		}
		if ( $this->command == 'insert' ) {
			$query = "delete from $this->table where $this->pKey = $this->id";
		} elseif ( $this->command == 'delete' ) {
			$this->select()->setWhere( "id=$this->id" )->query()->fetch();
			$query = $this->getInsertQuery();
		} elseif ( $this->command == 'update' ) {
			$this->select()->setWhere( "id=$this->id" )->query()->fetch();
			$query = $this->getUpdateQuery();
		}
		$this->rollbackQuery = $query;
	}
	/******************** from BoardIndex ******************/
	function getPage() {
		if ( $this->searchTotal() == 0 ) {
			return 1;
		}
		return ckKey( 'page', $_GET, '1' );
	}
	function getPages() {
		return ceil( $this->searchTotal() / $this->getRows() );
	}
	function setRows( $rows ) {
		$this->rows = $rows;
		return $this;
	}
	private $rows = 10;
	function getRows() {
		return $this->rows;
	}
	function getPageNavi() {
		if ( $this->isEmpty() ) {
			return '';
		}
		return new MadPageNavi( $this, 10 );
	}
}

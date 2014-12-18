<?
class MadQuery implements IteratorAggregate, Countable {
	protected $server = 'mysql';
 	protected $db = 'null';
	protected $command = 'select';
 	protected $table = '';
 	protected $tables = array();
	protected $select = '*';
	protected $having = array();
	protected $where = array();
	protected $order = array();
	public $limit = '10';
	protected $offset = 0;

	protected $set = array();

	protected $on = array();
	protected $group;

	protected $rollback = false;
	protected $rollbackQuery = '';

	protected $data = array();
	protected $count = 0;

	protected $model = null;
	protected $statement;

	function __construct( $table = '' ) {
		$this->db = MadDb::create();
		$this->table = $table;
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
		$this->set = $data;
		return $this;
	}
	function update( $data ) {
		$this->command = 'update';
		$this->set = $data;
		return $this;
	}
	function delete() {
		$this->command = 'delete';
		return $this;
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
			$this->where[] = $where;
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
		if ( ! $page = MadParams::create('get')->page ) {
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
	function setModel( $model ) {
		$this->model = $model;
		return $this;
	}
 	function query( $query = '' ) {
 		if ( ! $query ) {
 			$query = $this->getQuery();
 		}
 		$this->statement = $this->db->query( $query );
 		return $this;
 	}
 	function exec( $query = '' ) {
 		if ( ! $query ) {
 			$query = $this->getQuery();
 		}
		$this->createRollback();
		return $this->execQuery( $query, array_values($this->set) );
 	}
	function execQuery( $query, $values = array() ) {
		$statement = $this->db->prepare( $query );
		$statement->execute( $values );
		return $statement->rowCount();
	}
	/************************* getters **************************/
	function getDb() {
		return $this->db;
	}
	function getFrom() {
		return $this->db->escapeField( $this->table );
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
		return $this->$action();
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
		$set = $this->set;
		unset( $set[$this->pKey] );

		$keys = array_keys( $set );
		$table = $this->db->escapeField( $this->table );
		$set = implode( ',', $this->db->escapeFields( $keys ) );
		$placeholders = implode(',', array_fill( 0, count($keys), '?' ) );
		return "insert into $table ($set) values ($placeholders)";
	}
	function getUpdateQuery() {
		$set = $this->set;
		if ( ! $key = ckKey( $this->pKey, $set ) ) {
			return false;
		}
		$key = $this->db->escape( $key );
		$set = $this->getSet( $this->data );
		$where = $this->getWhere();
		return "update $this->table set $set $where";
	}
	function getDeleteQuery() {
		$where = $this->getWhere();
		return "delete from $this->table $where";
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
			$this->statement = $this->db->getStatement();
			$this->statement->setFetchMode( PDO::FETCH_INTO, $this->model );
		}
		return $this->statement;
	}
	function count() {
		return count( $this->data );
	}
	/******************* getter/setter *****************/
	function getData() {
		return $this->db->getData();
	}
	function setData( $data ) {
		$this->data = $data;
		return $this;
	}
	/****************** fetches *****************/
	function fetchAssoc() {
		return $this->db->query( $this->getQuery() )->fetchAssoc();
	}
	function fetch() {
		$this->query();
		$statement = $this->db->getStatement();
		$statement->setFetchMode( PDO::FETCH_INTO, $this->model );
		$statement->fetch();
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
	function isTable(){
		$query = "show tables like '$this->table'";
		return $this->db->query( $query )->rows();
	}
	/*************************** util ***************************/
	function total() {
		$query = "select count(*) from $this->table";
		return $this->db->query($query)->getFirst();
	}
	function searchTotal() {
		$where = $this->getWhere();
		$query = "select count(*) from $this->table $where";
		return $this->count = $this->db->query($query)->getFirst();
	}
	function drop() {
		return $this->db->exec("drop table $this->table");
	}
	function truncate() {
		return $this->db->exec( "truncate $this->table" );
	}
	function explain() {
		return $this->db->query( "explain $this->table" );
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
		return $this->db->exec( $this->rollbackQuery );
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

<?
// 여기에서 db 차이에 대한 것을 없앤다.
// use lazy setters
class MadQuery implements IteratorAggregate {
	private $server = 'pgsql';
	protected $command = 'select';
	protected $table = array();
	protected $select = '*';
	protected $having = array();
	protected $where = array();
	protected $order = array();
	public $limit = '';
	protected $offset = 0;

	private $set = null;

	protected $on = array();
	protected $group;

	protected $data = array();

	function __construct( $table ) {
		$this->db = MadDb::create();
		$this->from( $table );
	}
	function getCommand() {
		return $this->command;
	}
	/*************************** setters *************************/
	/******************** commands ********************/
	function drop() {
		$this->command = 'drop';
	}
	function truncate() {
		return Q::truncate( $this->table );
	}
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
		$this->data[] = $data;
		return $this;
	}
	function update( $data ) {
		$this->command = 'update';
		$this->data[] = $data;
		return $this;
	}
	function delete() {
		$this->command = 'delete';
		return $this;
	}
	function from( $table = '' ) {
		if ( empty( $table ) ) {
			$this->table = array();
		} else {
			$this->table[] = $table;
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
		if ( ! $page = MadParam::create('get')->page ) {
			$page = 1;
		}
		$this->offset = ( $page -1 ) * $this->limit;
		return $this;
	}
	function offset( $offset ) {
		$this->offset = $offset;
		return $this;
	}
	/******************* getter/setter *****************/
	function getData() {
		return $this->data;
	}
	function setData( $data ) {
		$this->data = $data;
		return $this;
	}
	/************************* getters **************************/
	function getFrom() {
		$table = $this->escapeField( $this->table );
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
	function getOrder() {
		if ( ! empty( $this->order ) ) {
			return 'order by ' . implode( ',', $this->order );
		}
		return '';
	}
	function getLimit() {
		if ( empty( $this->limit ) ) {
			return '';
		}
		return "limit $this->limit offset $this->offset";
	}
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
		$table = end( $this->table );
		$keys = $this->set->getKeys()->implode(',');
		$values = "'" . $this->set->getValues()->implode("','") . "'";
		return "insert into $table ( $keys ) values ( $values )";
	}
	function getUpdateQuery() {
		$table = end( $this->table );
		$set = $this->getSet();
		$where = $this->getWhere();
		return "update $table set $set $where";
	}
	function getDeleteQuery() {
		$table = end( $this->table );
		$where = $this->getWhere();
		return "delete from $table $where";
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
	/****************** fetches *****************/
	function fetchAssoc() {
		return $this->query()->fetchAssoc();
	}
	function fetch() {
		return $this->fetchObject();
	}
	function fetchObject( $class = '' ) {
		return $this->query()->fetchObject( $class );
	}
	function insertId() {
		return $this->query()->getInsertId();
	}
	function rows() {
		return $this->query()->getRows();
	}
	/*************************** db involed ***************************/
	function query() {
		return $this->db->query( $get->getQuery() );
	}
	function exec() {
		return $this->db->exec( $this );
	}
	/*************************** test ***************************/
	function isEmpty() {
		return empty( $this->data );
	}
	function test() {
		print $this;
		$this->db->query( $this->getQuery() )->test();
	}
	/************************* escape **************************/
	protected function escape( $value ) {
		if ( is_array( $value ) ) {
			foreach( $value as &$row ) {
				$row = $this->escape( $row );
			}
			return $this->escape( $value );
		}
		if ( ! preg_match( '/\)$/', $value ) ) {
		}
		if ( $this->server == 'mysql' ) {
			$value = mysql_real_escape_string( $value );
		} elseif ( $this->server == 'pgsql' ) {
			$value = pg_escape_string( $value );
		}
		$value = "'$value'";
		return $value;
	}
	protected function escapeField( $value ) {
		if ( is_array( $value ) ) {
			foreach( $value as &$row ) {
				$row = $this->escapeField( $row );
			}
			return $value;
		}
		if ( false !== strpos( '.', $value ) ) {
			$fields = explode( '.', $value );
			return implode( '.', $this->escapeField( $fields ) );
		}
		if ( $this->server == 'mysql' ) {
			return  "`$value`";
		} else if ( $this->server == 'pgsql' ) {
			return "\"$value\"";
		}
		return $value;
	}
	protected final function getSet() {
		$rv = array();
		foreach( $this->set as $key => $value ) {
			$value = $this->escape( $value );
			if ( $this->server == 'mysql' ) {
				$rv[] = "`$key`=$value";
			} else {
				$rv[] = "$key=$value";
			}
		}
		return implode( ', ', $rv );
	}
	function sqlin($string){
		if( is_array($string) ){
			$rv = array();
			foreach($string as $key => $value){
				$rv[$key] = $this->sqlin($value);
			}
		} else {
			$rv = '';
			$rv=trim($string);
			if(!get_magic_quotes_gpc()) $rv=addSlashes($rv);
		}
		return $rv;
	}
	function sqlout($string, $flag = false){
		if( is_array($string) ){
			$rv = array();
			foreach($string as $key => $value){
				$rv[$key]=$this->sqlout($value, $flag);
			}
		} else {
			$rv = '';
			$rv = $string;
			$rv = stripslashes($rv);
			if ( $flag ) {
				$rv = htmlspecialchars($rv);
			}
		}
		return $rv;
	}
}

<?
// 여기에서 db 차이에 대한 것을 없앤다.
// use lazy setters
class MadQuery extends Mad {
	protected $command = 'select';
	protected $select = '*';
	protected $table;
	protected $where;
	protected $order;
	protected $groupBy;
	protected $limit;

	protected $data = array();

	function __construct( $table = '' ) {
		parent::__construct();
		$this->from( $table );
		$this->order = new MadOrder;
		$this->limit = new MadLimit;
		$this->where = new MadWhere;
		$this->groupBy = new MadGroupBy;
	}
	/******************** commands ********************/
	function select( $select ) {
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
	function delete() {
		$this->command = 'delete';
		return $this;
	}
	function truncate() {
		return Q::truncate( $this->table );
	}
	/******************* from/where/... *******************/
	function from( $table ) {
		$this->table = $table;
		return $this;
	}
	function where( $condition ) {
		$this->where->add( $condition );
		return $this;
	}
	function orderBy( $order ) {
		$this->order->set( $order );
		return $this;
	}
	function groupBy( $column ) {
		$this->groupBy->add( $column );
		return $this;
	}
	function limit( $rows ) {
		$this->limit->setRows( $rows );
		return $this;
	}
	function setRows( $rows ) {
		$this->limit->setRows( $rows );
		return $this;
	}
	/******************** utilies ******************/
	function excute() {
		return new MadQ( $this );
	}
	function getQuery() {
		if ( $this->command == 'select' ) {
			return "$this->command $this->select from `$this->table` $this->where $this->order $this->limit";
		} elseif ( $this->command == 'update' ) {
			$set = new MadSet( $this->data );
			return "$this->command `$this->table` $set $this->where";
		} else if ( $this->command == 'insert' ) {
			$set = new MadSet( $this->data );
			return "$this->command into `$this->table` $set";
		} elseif ( $this->command == 'delete' ) {
			return "$this->command from `$this->table` $this->where";
		}
		return '';
	}
	/****************** not useful *****************/
	function getPageNavi() {
		return $this->limit->getPageNavi();
	}
	function isEmpty() {
		return empty( $this->data );
	}
	function getWhere() {
		return $this->where;
	}
	/****************** some fetches *****************/
	function fetchAssoc() {
		return $this->excute()->fetchAssoc();
	}
	function fetch() {
		return $this->fetchAssoc();
	}
	function fetchObject( $class = '' ) {
		return $this->excute()->fetchObject( $class );
	}
	function insertId() {
		return $this->excute()->getInsertId();
	}
	function rows() {
		return $this->excute()->getRows();
	}
	/******************* getter/setter *****************/
	function getData() {
		return $this->data;
	}
	function setData( $data ) {
		$this->data->setData( $data );
	}
	/***************** magic methods ********************/
	function __get( $key ) {
		return $this->data->$key;
	}
	function __set( $key, $value ) {
		$this->data->$key = $value;
	}
	function __toString() {
		return $this->getQuery();
	}
}

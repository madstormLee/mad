<?
class MadList extends Mad implements IteratorAggregate {
	protected $model = null;
	protected $data = array();
	protected $fields = '*';
	protected $table;
	protected $tables;
	protected $on = '';

	protected $where;
	protected $order;
	protected $groupBy;
	protected $limit;
	protected $search;
	protected $searchTotal = 0;

	// 구현해야 함.
	public $searchForms = array();

	function __construct( MadModel $model = null ) {
		parent::__construct();
		if ( $model instanceof MadModel ) {
			$this->model = $model;
			$this->setTable( $model->getTable() );
		} else {
			$this->setTable( substr( get_class( $this ), 0,-4 ) );
			
		}
		$this->order = new MadOrder;
		$this->limit = new MadLimit;
		$this->where = new MadWhere;
		$this->groupby = new MadGroupBy;
		// default order setting
		$this->setOrder('no desc');

		$this->search = new MadForm( new MadJson("json/$this->table/search") );
		$this->search->setModel( new User );
	}
	function setSearch( $search ) {
		$this->search = $search;
	}
	function getSearch() {
		return $this->search;
	}
	function search( $search ) {
		foreach( $search->filter() as $key => $value ) {
			if ( ! $this->search->$key ) {
				continue;
			}
			$type = $this->search->$key->type;
			if ( $type == 'text' ) {
				$like = 'like';
				if ( 0 === strpos( $value, '!' ) ) {
					$like = 'not like';
					$value = substr( $value, 1 );
				}
				$this->addWhere( "$key $like '%$value%'" );
			} else if ( $type == 'checkbox' ) {
				$value = implode( "','", $value->get() );
				$this->addWhere( "$key in ('$value')" );
			}
		}
	}
	function getSearchForms() {
		return new MadData;
	}
	// 구현해야 함.
	function getSelectedHeaders() {
		$q = new Q("explain $this->table");
		return $q->getColumn( 'Field' );
	}
	function get() {
		return $this->getData();
	}
	function setTable( $table ) {
		$this->tables = array();
		$this->addTable( $table );
		return $this;
	}
	function getTable() {
		return '`' . implode( '` inner join `', $this->tables ) . '`';
	}
	function addTable( $tableName ) {
		$this->tables[] = $tableName;
		$this->table = $this->getTable();
		return $this;
	}
	function on( $leftField, $rightField) {
		if ( count( $this->tables ) > 1 ) {
			$this->on = "on {$this->tables[0]}.$leftField = {$this->tables[1]}.$rightField";
		}
		return $this;
	}
	function setData() {
		$this->limit->setTotal( $this->getSearchTotal() );

		$query = "select * from $this->table $this->on $this->where $this->order $this->limit";
		$q = new Q($query);
		$this->data = $q->toObject();
		return $this;
	}
	function getData() {
		if ( empty( $this->data ) ) {
			$this->setData();
		}
		return $this->data;
	}
	function getSearchTotal() {
		if ( empty( $this->searchTotal ) ) {
			$this->setSearchTotal();
		}
		return $this->searchTotal;
	}
	protected function setSearchTotal() {
		$q = new MadQ( "select count(*) from $this->table $this->on $this->where" );
		$this->searchTotal = $q->getFirst();
		return $this;
	}
	function getIterator() {
		return new ArrayIterator($this->get());
	}
	function setOrder( $order ) {
		$this->order->set( $order );
		return $this;
	}
	function setNoLimit() {
		$this->limit->noLimit();
	}
	function setRows( $rows ) {
		$this->limit->setRows( $rows );
		return $this;
	}
	function addWhere( $where ) {
		$this->where->add( $where );
		return $this;
	}
	function getPageNavi() {
		return $this->limit->getPageNavi();
	}
	function isEmpty() {
		return empty( $this->data );
	}
	function addGroup( $column ) {
		$this->groupBy->add( $column );
	}
	function test() {
		(new MadDebug)->printR($this->data);
	}
	function getWhere() {
		return $this->where;
	}
}

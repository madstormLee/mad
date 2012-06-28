<?
class MadQuery {
	protected $table;
	protected $where = array();
	protected $order = array();
	protected $sess;
	protected $limit;

	public function __construct($table = '') {
		$this->table = $table;
		$this->sess = new MadSession(__class__);
	}
	public function setTable($table) {
		$this->table = $table;
		return $this;
	}
	public function getTable($table) {
		return $this->table;
	}
	public function setLimit($limit) {
		$limit = trim($limit);
		$limit = str_replace('limit','',$limit);
		$this->limit = $limit;
		return $this;
	}
	public function getLimit() {
		return " limit $this->limit";
	}
	public function addOrder($field, $way='desc') {
		$this->order[$field] = $way;
		return $this;
	}
	public function setOrder($field, $way='desc') {
		$this->order = array();
		$this->addOrder($field, $way);
		return $this;
	}
	public function getOrder() {
		$order = '';
		if ( ! empty( $this->order ) ) {
			$order = ' order by';
			foreach ( $this->order as $field => $way ) {
				$orders[] = " $field $way";
			}
			$order .= implode(',', $orders);
		}
		return $order;
	}
	public function addWhere($condition, $glue='and') {
		$glues = array('and','or');
		if ( in_array($glue, $glues) ) {
			$glue = $glue;
		} else {
			$glue = $glues[0];
		}
		$this->where[][$glue] = $condition;
		return $this;
	}
	public function getWhere() {
		$where = '';
		if ( !empty( $this->where ) ) {
			$where = ' where';
			$i = 0; foreach ( $this->where as $conditions ) {
				foreach ( $conditions as $glue => $condition ) {
					if ( $i == 0 ) {
						$where .= " $condition"; $i = 1;
					} else {
						$where .= " $glue $condition";
					}
				}
			}
		}
		return $where;
	}
	public function getQ() {
		$query = $this->getQuery();
		$q = new Q($query);
		return $q;
	}
	public function getTotal() {
		$where = $this->getWhere();
		$query = "select count(*) as cnt from $this->table $where"; 
		$q = new Q($query);
		$row = $q->row();
		if ( $q->rows() > 0 ) {
			return $row['cnt'];
		} else {
			return 0;
		}
	}
	public function getTableTotal() {
		$query = "select count(*) as cnt from $this->table"; 
		$q = new Q($query);
		$row = $q->row();
		return $row['cnt'];
	}
	public function getQuery() {
		$where = $this->getWhere();
		$limit = $this->getLimit();
		$order = $this->getOrder();
		$query = "select * from $this->table $where $order $limit";
		$this->sess->lastQuery = $query;
		return $query;
	}
	public function getLastQuery() {
		return $this->sess->lastQuery;
	}
	public function test() {
		print $this->getQuery();
	}
	public function __toString() {
		return $this->getQuery();
	}
}

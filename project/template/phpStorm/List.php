<?
class {name}List extends MadQuery {
	function __construct() {
		parent::__construct();
	}
	function fetchList() {
		$this->searchTotal = Q::total($this->table, $this->where);
		$this->limit->setTotal( $this->searchTotal );

		$query = "select * from $this->table $this->where $this->order $this->limit";
		$q = new Q($query);
		$this->data = $q->toArray();
		parent::fetchList();
		return $this;
	}
}

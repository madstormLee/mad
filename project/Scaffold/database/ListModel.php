<?='<?'?>
class <?=$config->name?>List extends MadList {
	function setData() {
		$this->searchTotal = Q::total($this->table, $this->where);
		$this->limit->setTotal( $this->searchTotal );

		$query = "select * from $this->table $this->where $this->order $this->limit";
		$q = new Q($query);
		$this->data = $q->toArray();
		foreach( $this->data as $key => &$row ) {
			$row = sqlout( $row );
		}
		return $this;
	}
}

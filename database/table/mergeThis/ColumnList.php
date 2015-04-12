<?
class ColumnList extends MadList {
	protected $data;
	function __construct( $table ) {
		parent::__construct();
		$this->table = $table;
	}
	function setData() {
		$query = "show full columns from crm.`{$this->table}`";
		$q = new ProjectQ($query);
		$this->data = $q->toObject();
		return $this;
	}
}

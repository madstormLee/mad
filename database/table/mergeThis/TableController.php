<?
class TableController extends MadController {
	function indexAction() {
		$list = new TableList($this->get->database);
		$list->setData();
		
		$this->main->list = $list;
		return $this->main;
	}
	function viewAction() {
		$database = $this->get->database;
		$table = $this->get->table;
		$query = "show full columns from $database.$table";
		$q = new ProjectQ($query);
		
		$this->main->list = $q->toArray();
		$this->main->table = $this->get->table;
		return $this->main;
	}
	function definitionListAction() {
		$list = new ColumnList( $this->get->table );
		$this->main->list = $list;
		$table = new Table( $this->get->table );
		$table->setInfo();
		$table->database = $this->get->database;

		$this->main->table = $table;
		return $this->main;
	}
}

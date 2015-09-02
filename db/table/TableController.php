<?
class TableController extends MadController {
	function indexAction() {
		$get = $this->get;
		$list = new TableList( $get );
		if ( $get->table_name ) {
			$list->where( "table_name like '%$get->table_name%'" );
		}
		$this->view->list = $list;
	}
	function viewAction() {
		$database = $this->get->database;
		$table = $this->get->table;
		$query = "show full columns from $database.$table";
		$q = new ProjectQ($query);
		
		$this->view->list = $q->toArray();
		$this->view->table = $this->get->table;
		return $this->view;
	}
	function columnAction() {
		$get = $this->params;
		$list = new MadIndex;
		$list->from($get->table_name);
		$this->view->list = $list;
	}
	function view10rowsAction() {
		$this->view->q = $this->db->query( "select * from userinfo limit 10" )->getData();
	}
	function schemeAction() {
	}
	function columnsAction() {
		if ( IS_AJAX ) {
			$this->view->setView( 'views/Table/entity.html' );
		}
		$this->view->table = new Table( $get->table );
	}
	function columnsAction() {
		$this->view->table = $this->model->fetch( $this->params->table );
	}
	function definitionListAction() {
		$list = new ColumnList( $this->get->table );
		$this->view->list = $list;
		$table = new Table( $this->get->table );
		$table->setInfo();
		$table->database = $this->get->database;

		$this->view->table = $table;
		return $this->view;
	}
}

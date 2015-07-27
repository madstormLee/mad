<?
class TableController extends MadController {
	function indexAction() {
		$get = $this->get;
		$list = new TableList( $get );
		if ( $get->table_name ) {
			$list->where( "table_name like '%$get->table_name%'" );
		}
		$this->main->list = $list;
	}
	function columnAction() {
		$get = $this->params;
		$list = new MadListModel;
		$list->from($get->table_name);
		$this->main->list = $list;
	}
	function view10rowsAction() {
		$this->main->q = $this->db->query( "select * from userinfo limit 10" )->getData();
	}
	function schemeAction() {
	}
	function columnsAction() {
		if ( IS_AJAX ) {
			$this->main->setView( 'views/Table/entity.html' );
		}
		$this->main->table = new Table( $get->table );
	}
	function columnsAction() {
		$this->main->table = $this->model->fetch( $this->params->table );
	}
}

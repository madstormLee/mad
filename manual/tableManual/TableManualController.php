<?
class TableManualController extends MadController {
	function indexAction() {
		$get = $this->get;

		$model = new TableManual;
		$model->getTableComment( 'item', 'itemshop' );
		$this->main->list = $model->getList("table_schema = 'itemshop'");
		$this->main->model = $model;
	}
	function listAction() {
		$list = new TableList( $this->get );
		// assume project is already opend and exists database connection information.
		$this->main->list = $list;
	}
	function columnAction() {
		$get = $this->get;
		$list = new MadListModel;
		$list->from($get->table_name);
		$this->main->list = $list;
	}
	function view10rowsAction() {
		$db = MadDb::create();
		$this->main->q = $db->query( "select * from userinfo limit 10" )->getData();
	}
	function schemeAction() {
	}
	function columnsAction() {
		if ( IS_AJAX ) {
			$this->main->setView( 'views/Table/entity.html' );
		}
		$get = $this->get;
		$this->main->table = new Table( $get->table );
	}
}

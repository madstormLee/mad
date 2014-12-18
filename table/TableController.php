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
	function listAction() {
		$list = new TableList( $this->get );
		// assume project is already opend and exists database connection information.
		$list->setDatabase( $this->projectLog->configs->databases->default );
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

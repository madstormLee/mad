<?
class LiteController extends MadController {
	function indexAction() {
		$query = "select * from test";
		$this->view->list = MadDb::create('sqlite:data.db')->query( $query );
	}
}

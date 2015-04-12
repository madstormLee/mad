<?
class DateController extends MadController {
	function indexAction() {
		$this->view->dbDate = date('Y-m-d H:i:s'); // MadDb::create()->query("select now()")->getFirst();
	}
}

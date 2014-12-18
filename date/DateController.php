<?
class DateController extends MadController {
	function indexAction() {
		$this->main->list = new Date;
		$this->main->dbDate = MadDb::create()->query("select now()")->getFirst();
	}
}

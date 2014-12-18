<?
class PgProcController extends MadController {
	function indexAction() {
		$this->db->query("SELECT * FROM pg_proc")->test();
		$searchWord = 'happyitem_log';
		$query = "select * from pg_proc where prosrc like '%happyitem_log%'";
	}
}

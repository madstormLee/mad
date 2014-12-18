<?
class LocaleTableController extends MadController {
	function indexAction() {
		$get = $this->get;

		$list = new MadListModel;
		$list->from($get->table_name);
		$this->main->list = $list;
	}
}

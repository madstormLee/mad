<?
class DatabaseController extends Preset {
	function __construct() {
		parent::__construct();
		$this->model = new Database;
	}
	function indexAction() {
		$this->js->replace( "~/$this->controllerName/list" );
	}
	function listAction() {
		$list = $this->model->getList();
		
		$this->main->list = $list;
		return $this->main;
	}
	function definitionListAction() {
		
		$q = new ProjectQ("select * from information_schema.TABLES where TABLE_SCHEMA like '{$this->get->database}'");
		$list = $q->toArray();
		$this->main->list = $list;
		return $this->main;
	}
}

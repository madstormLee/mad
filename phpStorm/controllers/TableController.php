<?
class TableController extends Preset {
	function __construct() {
		parent::__construct();
	}
	function indexAction() {
	}
	function listAction() {
		$list = new TableList($this->get->database);
		$list->setData();
		
		$this->main->list = $list;
		return $this->main;
	}
	function viewAction() {
		$database = $this->get->database;
		$table = $this->get->table;
		$query = "show full columns from $database.$table";
		$q = new ProjectQ($query);
		
		$this->main->list = $q->toArray();
		$this->main->table = $this->get->table;
		return $this->main;
	}
	function definitionListAction() {
		

		$list = new ColumnList( $this->get->table );
		$this->main->list = $list;
		$table = new Table( $this->get->table );
		$table->setInfo();
		$table->database = $this->get->database;

		$this->main->table = $table;
		return $this->main;
	}
	function downloadPdfAction() {
		MadHeaders::download( "$this->controllerName.pdf", 'pdf');
		$downloader = new Web2Pdf( $this->controllerName );
		$downloader->setTarget("/phpStorm/$this->controllerName/viewAll");
		print $downloader;
	}
	function viewAllAction() {
		$this->setLayout( new MadView('layouts/printView') );
		$this->style->add("~/css/$this->controllerName/definitionList")
			->add('/phpStorm/css/viewAll')
			->add("~/css/Table/definitionList")
			->add("~/css/Database/definitionList");

		$this->main = new TableViewAll;

		if ( ! $this->main->cacheExists() &&
				! $this->main->updateCache() ) {
			return new MadMessageCode('fileCreateFailed');
		}
		return $this->main;
	}
}

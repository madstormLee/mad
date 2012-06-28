<?
class TableDiagramController extends Preset {
	function __construct() {
		parent::__construct();
	}
	function indexAction() {
		replace( "$this->projectRoot$this->controllerName/list" );
	}
	function listAction() {
		$list = new TableDiagramList( $this->phpStorm->getDir('diagrams') . 'table/' );
		
		$this->main->list = $list;
		return $this->main;
	}
	function viewAction() {
		$table = new TableDiagram( $this->get->file );
		$table->interpret('oracle');

		
		$this->main->table = $table;
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
		$this->style
			->add("~/css/$this->controllerName/definitionList")
			->add("~/css/$this->controllerName/list")
			->add("~/css/$this->controllerName/view")
			->add('/phpStorm/css/viewAll')
			->add("~/css/Table/definitionList")
			->add("~/css/Database/definitionList");

		$this->main = new TableViewAll( $this->phpStorm->getDir('views') . 'Table/viewAll.html' );
		// $this->main->updateCache();

		if ( ! $this->main->cacheExists() &&
				! $this->main->updateCache() ) {
			return new MadMessageCode('fileCreateFailed');
		}
		return $this->main;
	}
	function createFromConfigsAction() {
		$get = $this->get;
		$phpStorm = $this->phpStorm;

		$configs = new ConfigList( $phpStorm->getDir('configs') );
		$targetDir = $phpStorm->getDir('diagrams') . 'table/';
		$cnt = 0;
		foreach( $configs as $config ) {
			$tableDiagram = new TableDiagram( $targetDir . $config->name );
			$tableDiagram->setData( $config );
			$tableDiagram->id = $config->name . '00';
			$tableDiagram->dbName = $phpStorm->info->name;
			$tableDiagram->type = 'BASE TABLE';
			$cnt += $tableDiagram->save();
		}
		alert( $cnt . ' 개의 파일이 생성되었습니다.', 'back', 'replace');
	}
}

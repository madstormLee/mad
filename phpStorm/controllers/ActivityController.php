<?
class ActivityController extends Preset {
	function __construct() {
		parent::__construct();
		$this->model = new Activity;
	}
	function indexAction() {
		$this->js->replace( "~/$this->controllerName/list" );
	}
	function listAction() {
		$list = new ActivityList( $this->project->getDir('diagrams') . 'activity/' );
		
		$this->main->list = $list;
		return $this->main;
	}
	function writeAction() {
		$this->setLayout( new MadView('Interface/writeLayout') );
		$this->layout->footer = new MadView('footer');
		$this->style->clear()
			->add("~/css/writeBase")
			->add("~/css/Activity/write");

		$this->main->table = new MadData;
		$this->main->activityList = new MadList;
		return $this->main;
	}
	function viewAction() {
		$this->main->model = $this->model->load( $this->get->file );
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
		$this->style->add("~/css/$this->controllerName/view")
			->add('/phpStorm/css/viewAll')
			->add('/phpStorm/css/Component/list');

		$this->main = new ActivityViewAll($this->phpStorm->getDir('views') . 'Activity/viewAll.html');
		$this->main->updateCache();

		if ( ! $this->main->cacheExists() &&
				! $this->main->updateCache() ) {
			return new MadMessageCode('fileCreateFailed');
		}

		return $this->main;
	}
	function createFromConfigsAction() {
		$phpStorm = $this->phpStorm;
		$configs = new ConfigList( $phpStorm->getDir('configs') );
		$this->main = new MadView('json/prototype/activity.json');
		$activity = new Activity;
		$cnt = 0;
		foreach( $configs as $config ) {
			$activity->setFile( $phpStorm->getDir('diagrams') . 'activity/' . $config->name );

			$this->main->name = $config->name;
			$this->main->label = $config->label;
			$activity->setData( json_decode($this->main->get()) );

			$cnt += $activity->save();
		}
		$this->js->alert( $cnt . '개의 파일이 생성되었습니다.')->replaceBack();
	}
}

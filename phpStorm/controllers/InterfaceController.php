<?
class InterfaceController extends Preset {
	function __construct() {
		parent::__construct();
		$this->model = new InterfaceDiagram;
		if ( ! $this->phpStorm->isOpened() ) {
			$this->js->replace( "/$this->projectName" );
		}
	}
	function indexAction() {
		$this->js->replace( "$this->projectName$this->controllerName/list" );
	}
	function listAction() {
		$this->js->add('/mad/js/prototype');

		
		$list = new InterfaceDiagramList( $this->phpStorm->getDir('diagrams') . 'interface/' );
		$this->main->list = $list;
		$this->main->viewsDir = $this->phpStorm->getDir('views');
		return $this->main;
	}
	function viewAction() {
		$this->setLayout( new MadView('Interface/writeLayout') );
		$this->js->add('/mad/js/prototype');
		$this->layout->footer = new MadView('footer');
		$this->style->clear()
			->add("~/css/writeBase")
			->add("~/css/Interface/write");

		$get = $this->get;
		$model = $this->model;

		$model->load( $get->file );

		$preview = new Preview( $get->preview );

		
		$this->main->model = $model->actions->{$get->action};
		$this->main->preview = $preview;
		return $this->main;
	}
	function writeAction() {
		$this->setLayout( new MadView('Interface/writeLayout') );
		$this->js->add('/mad/js/prototype');
		$this->layout->footer = new MadView('footer');
		$this->style->clear()
			->add("$this->projectRoot/css/writeBase")
			->add("$this->projectRoot/css/Interface/write");

		$get = $this->get;
		$model = new InterfaceDiagram( $get->file );

		$preview = new Preview( $get->preview );

		
		if ( $model->actions ) {
			$this->main->data = $model->actions->{$get->action};
		} else {
			$this->main->data = new MadData;
			$this->main->data->contents = array();
		}
		if ( $preview->isFile() ) {
			$this->main->preview = $preview;
		} else {
			$this->main->preview = '';
		}
		return $this->main;
	}
	function saveAction() {
		$post = $this->post;
		$get = $this->get;
		$model = $this->model;

		$model->load( $get->file );

		$target = $model->actions->{$get->action};
		$target->addData( $post );
		print $model->save();
		die;
	}
	function downloadPdfAction() {
		MadHeaders::download( "$this->controllerName.pdf", 'pdf');
		$downloader = new Web2Pdf( $this->controllerName );
		$downloader->setTarget("/phpStorm/$this->controllerName/viewAll");
		print $downloader;
	}
	function viewAllAction() {
		$this->setLayout( new MadView('layouts/printView') );
		$this->style->clear()
			->add("~/css/Interface/write")
			->add('~/css/Interface/list')
			->add("~/css/writeBase")
			->add('~/css/viewAll');

		$this->main = new InterfaceViewAll( $this->phpStorm->getDir('views') . 'Interface/viewAll.html' );
		// $this->main->clear();

		if ( ! $this->main->cacheExists() &&
				! $this->main->updateCache() ) {
			return new MadMessageCode('fileCreateFailed');
		}

		return $this->main;
	}
	function createFromConfigsAction() {
		$phpStorm = $this->phpStorm;

		$targetDir = $phpStorm->getDir('diagrams') . 'interface/';
		$configs = new ConfigList( $phpStorm->getDir('configs') );

		$convertor = new Config2Interface( $targetDir );
		$convertor->setName( $this->phpStorm->info->label );

		$cnt = 0;
		foreach( $configs as $config ) {
			$convertor->setConfig( $config );
			$cnt += $convertor->save();
		}
		$this->js->alert( $cnt . '개의 파일이 생성되었습니다.')->replaceBack();
	}
}

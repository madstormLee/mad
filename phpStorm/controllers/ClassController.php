<?
class ClassController extends Preset {
	function __construct() {
		parent::__construct();
		$this->model = new ClassDiagram;
	}
	function indexAction() {
		$this->js->replace( "$this->projectName$this->controllerName/list" );
	}
	function listAction() {
		
		$list = new ClassDiagramList( $this->phpStorm->getDir('diagrams') . 'class/' );
		$this->main->list = $list;
		return $this->main;
	}
	function viewAction() {
		
		$model = new ClassDiagram( $this->get->file );
		$this->main->model = $model;

		$this->main->controllerMethods = $model->getControllerMethods();
		$this->main->modelMethods = $model->getModelMethods();

		return $this->main;
	}
	function writeAction() {
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
			->add('~/css/viewAll')
			->add("~/css/$this->controllerName/list");

		$this->main = new ClassViewAll( $this->phpStorm->getDir('views') . 'Class/viewAll.html' );
		$this->main->updateCache();

		if ( ! $this->main->cacheExists() &&
				! $this->main->updateCache() ) {
			return new MadMessageCode('fileCreateFailed');
		}

		return $this->main;
	}
	// 아무래도 답이 안 나온다. default처리하되, writable하게 간다.
	function viewModelAction() {
		$name = 'User';
		$model = new $name;

		$analyzer = new ClassAnalyzer( $model );
		$methods = $analyzer->getUsefulMethods();
		printR( $methods );
		die;
	}
	function viewControllerAction() {
		$name = 'UserController';
		include "controllers/$name.php";
		$controller = new $name;
		$methods = $controller->getActions();
		printR( $methods );
		die;
		
		$json = new MadJson( $this->configDir . 'User.json' );
		$this->main->model = $json;
		return $this->main;
	}
	function createFromConfigsAction() {
		$get = $this->get;
		$model = $this->model;
		$phpStorm = $this->phpStorm;

		$configs = new ConfigList( $phpStorm->getDir('configs') );
		$cnt = 0;
		$this->main = new MadView('json/prototype/class.json');
		foreach( $configs as $config ) {
			$name = new MadString($config->name);
			$config->name = $name->lower()->camel()->ucFirst();
			$model->setFile( $phpStorm->getDir('diagrams') . 'class/' . $config->name );
			$this->main->config = $config;
			$this->main->project = $phpStorm->info->name;
			$model->setFromRaw($this->main);
			$cnt += $model->save();
		}
		$this->js->alert( $cnt . ' 개의 파일이 생성되었습니다.')->replaceBack();
	}
}

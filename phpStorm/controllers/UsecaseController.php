<?
class UsecaseController extends Preset {
	function __construct() {
		parent::__construct();
		$this->model = new Usecase;
	}
	function indexAction() {
		replace( "$this->projectName$this->controllerName/list" );
	}
	function listAction() {
		$list = new UsecaseList;
		$list->setDir( $this->phpStorm->getDir('diagrams') . 'usecase/' );

		
		$this->main->list = $list;

		return $this->main;
	}
	function downloadPdfAction() {
		MadHeaders::download( "$this->controllerName.pdf", 'pdf');
		$downloader = new Web2Pdf( $this->controllerName );
		$downloader->setTarget("/phpStorm/$this->controllerName/viewAll");
		print $downloader;
	}
	function viewAction() {
		$model = new MadJson( $this->get->file );
		
		$this->main->model = $model;
		return $this->main;
	}
	function viewAllAction() {
		$this->setLayout( new MadView('layouts/printView') );
		$this->style->add("~/css/$this->controllerName/view")
			->add('~/css/viewAll')
			->add("~/css/$this->controllerName/list");

		$this->main = new UsecaseViewAll;
		$this->main->updateCache();

		if ( ! $this->main->cacheExists() &&
				! $this->main->updateCache() ) {
			return new MadMessageCode('fileCreateFailed');
		}

		return $this->main;
	}
	function viewAllActionTemp() {
		$this->setLayout( new MadView('layouts/printView') );
		$this->style->add('~/css/Usecase/view');

		$file = $this->phpStorm->getDir('views') . $this->controllerName . '/viewAll.html';
		$this->main = new MadCacheView( $file );

		if ( ! $this->main->cacheExists() ) {
			$contents = '';
			$list = new UsecaseList;
			$list->setDir( $this->phpStorm->getDir('usecases/') );
			$usecaseView = new MadView( 'Usecase/view' );
			foreach( $list as $usecase ) {
				$usecaseView->model = $usecase;
				$contents .= $usecaseView;
			}
			if ( ! $this->main->updateCache( $contents ) ) {
				return new MadMessageCode('fileCreateFailed');
			}
		}
		return $this->main;
	}
	function writeAction() {
		$this->model->fetch( $this->get->no );
		$form = new MadForm( $this->model );
		
		$this->main->form = $form;
		$this->main->model = $this->model;
		return $this->main;
	}
	function createFromConfigsAction() {
		$phpStorm = $this->phpStorm;

		$targetDir = $phpStorm->getDir('diagrams') . 'usecases/';
		$configs = new ConfigList( $phpStorm->getDir('configs') );

		$model = $this->model;
		$template = new MadView( 'json/Usecase/basicUsecase.json' );
		$cnt = 0;
		foreach( $configs as $config ) {
			$model->setFile( $phpStorm->getDir('diagrams') . 'usecase/' . $config->name );
			$template->config = $config;
			$model->setFromRaw( $template->get() );
			$model->getFile();
			$cnt += $model->save();
		}
		$template->setView( 'json/Usecase/basicListUsecase.json' );
		foreach( $configs as $config ) {
			$model->setFile( $phpStorm->getDir('diagrams') . 'usecase/' . $config->name . 'List' );
			$template->config = $config;
			$model->setFromRaw( $template->get() );
			$model->getFile();
			$cnt += $model->save();
		}
		alert( $cnt . '개의 파일이 생성되었습니다.', 'back', 'replace' );
	}
	function insertAction() {
		if ( $this->model->setData( $this->post->get() )->insert() ) {
			return true;
		}
		return false;
	}
	function updateAction() {
		if ( $this->model->setData( $this->post->get() )->update() ) {
			return true;
		}
		return false;
	}
	function deleteAction() {
		if ( $this->model->delete( $this->get->no ) ) {
			return true;
		}
		return false;
	}
}

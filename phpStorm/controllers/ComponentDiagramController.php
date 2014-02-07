<?
class ComponentDiagramController extends Preset {
	private $configDir = '';
	function __construct() {
		parent::__construct();
		$this->model = new Component;
		$this->configDir = $this->project->getRoot() . 'configs';
	}
	function indexAction() {
		$this->js->replace( "$this->projectRoot$this->controllerName/list" );
	}
	function listAction() {
		$list = new ComponentList( $this->project->getDir('diagrams') . 'component/' );
		$this->main->list = $list;

		return $this->main;
	}
	function viewAction() {
		
		$this->main->model = $this->model->load( $this->get->file );
		return $this->main;
	}
	function downloadPdfAction() {
		MadHeaders::download( "$this->controllerName.pdf", 'pdf');
		$downloader = new Web2Pdf( $this->controllerName );
		$downloader->setTarget("/project/$this->controllerName/viewAll");
		print $downloader;
	}
	function viewAllAction() {
		$this->setLayout( new MadView('layouts/printView') );
		$this->style->add("~/css/$this->controllerName/view")
			->add('/project/css/viewAll')
			->add('/project/css/Component/list');

		$this->main = new ComponentViewAll( $this->project->getDir('views') . 'Component/viewAll' );
		$this->main->updateCache();

		if ( ! $this->main->cacheExists() &&
				! $this->main->updateCache() ) {
			return new MadMessageCode('fileCreateFailed');
		}
		return $this->main;
	}
	function createFromConfigsAction() {
		$get = $this->get;
		$model = $this->model;
		$project = $this->project;

		$configs = new ConfigList( $project->getDir('configs') );
		$cnt = 0;
		foreach( $configs as $config ) {
			$model->setFile( $project->getDir('diagrams') . 'component/' . $config->name );
			$data = array(
					'name' => $config->name,
					'label' => $config->label,
					'description' => $config->label . '의 정보를 제공 하는 데이터 액세스 컴포넌트',
					'interface' => array(
						'name' => $config->name . 'Interface',
						'description' => $config->label . ' 관리 및 검색을 위한 데이터 처리 인터페이스',
						),
					'controller' => array(
						'name' => $config->name . 'Controller',
						'description' => $config->label . ' 정보 제공을 위한 컨트롤러 클래스',
						),
					'model' => array(
						'name' => $config->name,
						'description' => $config->label . ' 관리 및 검색 서비스 구현 클래스',
						),
					);
			$model->setData( $data );
			$cnt += $model->save();
		}
		$this->js->alert( $cnt . ' 개의 파일이 생성되었습니다.')->replaceBack();
	}
}

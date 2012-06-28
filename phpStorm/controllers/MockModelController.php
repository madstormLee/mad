<?
class MockModelController extends Preset {
	function __construct() {
		parent::__construct();
		$action = $this->get->action;
		$this->main = new MadView("views/MockModel/{$action}");

		$interface = new InterfaceDiagram( $this->get->file );
		$this->mockData = $interface->{$action};

		$configFile = $this->phpStorm->getDir('configs') . baseName( $this->get->file );
		$this->config = new MadConfig( $configFile );

		$model = new MockModel( $this->mockData );
		$model->setConfig( $this->config );
		$model->setMockData( $this->mockData );
		$this->model = $model;

		$this->main->config = $this->config;
		$this->main->model = $this->model;
		$this->main->mockData = $this->mockData;
		$this->main->formFactory = new MadFormFactory;
		$this->view = $this->main;
	}
	function listAction() {
		$list = new MockModelList;
		$list->setConfig( $this->config );
		$list->setMockData( $this->mockData );

		$this->view->list = $list;
		return $this->view;
	}
	function writeAction() {
		return $this->view;
	}
	function viewAction() {
		return $this->view;
	}
}

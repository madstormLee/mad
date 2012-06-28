<?
class ConfigController extends Preset {
	function __construct() {
		parent::__construct();
		$this->model = new MadConfig;
	}
	function indexAction() {
		$this->js->replace("~/$this->controllerName/list");
	}
	function listAction() {
		$list = new ConfigList( $this->phpStorm->getDir('configs') );
		$this->main->list = $list;

		return $this->main;
	}
	function viewAction() {
		$this->main->model = $this->model->load( $this->get->file );
		return $this->main;
	}
	function writeAction() {
		$this->main->model = $this->model->load( $this->get->file );
		return $this->main;
	}
}

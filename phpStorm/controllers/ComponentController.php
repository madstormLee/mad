<?
class ComponentController extends Preset {
	function __construct() {
		parent::__construct();
	}
	function listAction() {
		$this->main->list = new ComponentList( $this->project->getRoot() . 'json/Components' );;
		return $this->main;
	}
	function viewAction() {
		$this->main->model = $this->model->load( $this->get->file );
		return $this->main;
	}
}

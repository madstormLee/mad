<?
class LayoutController extends MadController {
	function indexAction() {
	}
	function viewAction() {
		$this->model->fetch( $this->params->id );
		$this->layout = new MadView("$this->component/data/{$this->params->id}/layout.html");
	}
}

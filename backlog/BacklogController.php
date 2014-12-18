<?
class BacklogController extends MadController {
	function indexAction() {
	}
	function viewAction() {
	}
	function writeAction() {
	}
	function widgetAction() {
	}
	function addTextAction() {
		return $this->model->addText( $this->params->contents );
	}
	function saveAction() {
		return $this->model->setJson($this->params->contents)->save();
	}
	function deleteAction() {
		return $this->model->delete();
	}
}

<?
class JournalController extends MadController {
	function indexAction() {
	}
	function viewAction() {
	}
	function writeAction() {
	}
	function saveAction() {
		return $this->model->setData($this->params)->save();
	}
	function deleteAction() {
		return $this->model->delete();
	}
}

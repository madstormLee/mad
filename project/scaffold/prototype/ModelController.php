<?
class {id}Controller extends MadController {
	function indexAction() {
	}
	function writeAction() {
		$this->model->fetch( $this->get->id );
	}
	function viewAction() {
		$this->model->fetch( $this->get->id );
	}
	function saveAction() {
		return $this->model->setData( $this->params )->save();
	}
	function deleteAction() {
		return $this->model->delete( $this->params->id );
	}
}

<?
class AboutController extends MadController {
	function indexAction() {
		$list = $this->model->getList();
		$this->main->list = $this->list;
		return $this->main;
	}
	function writeAction() {
		$this->model->fetch( $this->get->no );
		$form = new MadForm( $this->model );
		$this->main->form = $form;
		return $this->main;
	}
	function viewAction() {
		return $this->main->set( 'model' , $this->model->fetch( $this->get->no ) );
	}
	function insertAction() {
		return $this->model->insert($this->post);
	}
	function updateAction() {
		return $this->model->update($this->post);
	}
	function deleteAction() {
		return $this->model->delete( $this->get->no );
	}
}

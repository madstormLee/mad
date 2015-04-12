<?
class {name}Controller extends {project}AdminTemplate {
	function indexAction() {
	}
	function listAction() {
		$view = new MadView;
		$list = $this->model->getList();
		$view->list = $list;
		$view->model = $this->model;
		return $view;
	}
	function writeAction() {
		$view = new MadView;
		$this->model->fetch( $this->get->no );
		$view->form = new MadForm( $this->model );
		return $view;
	}
	function viewAction() {
		$view = new MadView;
		$view->model = $this->model->fetch( $this->get->no );
		return $view;
	}
	function insertAction() {
		if ( $this->model->setData( $this->post->get() )->insert() ) {
			return new MadMessageCode('saved');
		}
		return new MadMessageCode('saveFailed');
	}
	function updateAction() {
		if ( $this->model->setData( $this->post->get() )->update() ) {
			return new MadMessageCode('updated');
		}
		return new MadMessageCode('updateFailed');
	}
	function deleteAction() {
		if ( $this->model->delete( $this->get->no ) ) {
			return new MadMessageCode('deleted');
		}
		return new MadMessageCode('deleteFailed');
	}
}

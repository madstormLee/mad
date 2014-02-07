<?
class {name}Controller extends MadController {
	function indexAction() {
		$list = new {name}List($this->model);
		$view = new MadView;
		$view->list = $list;
		return $view;
	}
	function createAction() {
		if ( $this->model->setData( $this->post->get() )->insert() ) {
			return new MadMessageCode('saved');
		}
		return new MadMessageCode('saveFailed');
	}
	function readAction() {
		$this->model->fetch( $this->get->no );
		$form = new MadForm( $this->model );
		$view = new MadView;
		$view->form = $form;
		$view->model = $this->model;
		return $view;
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

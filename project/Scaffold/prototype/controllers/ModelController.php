<?
class {id}Controller extends PxController {
	function indexAction() {
		$this->main->list = new {id}List($this->get);
	}
	function writeAction() {
		$this->main->model = new {id}( $this->get->id );
	}
	function viewAction() {
		$this->main->model = new {id}( $this->get->id );
	}
	function saveAction() {
		$model = new {id};
		$model->setData( $this->post )->save();
		$this->js->replace('./index');
	}
	function deleteAction() {
		$model = new {id};
		$model->delete( $this->post->id );
		$this->js->replace('./index');
	}
}

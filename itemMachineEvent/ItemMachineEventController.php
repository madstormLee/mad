<?
class ItemMachineEventController extends MadController {
	function indexAction() {
		$list = new ItemMachineEventList( $this->get );
		$list->limit();
		$list->order('id desc');
		$this->main->list = $list;
	}
	function selectorAction() {
		$list = new ItemMachineEventList( $this->get );
		$list->limit();
		$list->order('id desc');
		$this->main->list = $list;
	}
	function writeAction() {
		$this->css->add( "http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/themes/base/jquery-ui.css" );
		$this->js->addNext("http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js", 'jquery');

		$this->main->model = new ItemMachineEvent( $this->get->id );
		$this->main->events = new MachineEventTree;
	}
	function saveAction() {
		$model = new ItemMachineEvent;
		$post = $this->post;
		if ( empty( $post->id ) ) {
			$model->setData( $post )->insert();
		} else {
			$model->setData( $post )->update();
		}
		$this->js->replace('./');
	}
	function deleteAction() {
		$model = new ItemMachineEvent;
		$model->delete( $this->get->id );
		$this->js->replace('./');
	}
}

<?
class SyncController extends Preset {
	function indexAction() {
		return new MadView;
	}
	function listAction() {
		$list = new SyncList;
		$list->setData();
		
		$this->main->list = $list;
		return $this->main;
	}
	// not yet.
	function writeAction() {
		$this->model->fetch( $this->get->no );
		$form = new MadForm( $this->model );
		
		$this->main->form = $form;
		return $this->main;
	}
	function viewAction() {
		$this->model->fetch( $this->get->no );
		
		return $this->main;
	}
	function insertAction() {
		if ( $this->model->insert($this->post) ) {
			return true;
		}
		return false;
	}
	function updateAction() {
		if ( $this->model->update($this->post) ) {
			return true;
		}
		return false;
	}
	function deleteAction() {
		if ( $this->model->delete( $this->get->no ) ) {
			return true;
		}
		return false;
	}
	function getMessageCode( $code ) {
		return MadMessageCodeManager::getInstance()->$code();
	}
}

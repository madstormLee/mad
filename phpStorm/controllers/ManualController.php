<?
class ManualController extends MadController {
	function __construct() {
		parent::__construct();
		$this->model = new Manual;
	}
	function indexAction() {
	}
	function listAction() {
		$list = $this->model->getList();
		$this->main = new MadView( $this->action );
		$this->main->list = $list;
		return $this->main->setData( $this->model );
	}
	function writeAction() {
		$this->model->fetch( $this->get->no );
		$form = new MadForm( $this->model );
		$this->main = new MadView( $this->action );
		$this->main->form = $form;
		return $this->main->setData( $this->model );
	}
	function viewAction() {
		$this->model->fetch( $this->get->no );
		$this->main = new MadView( $this->action );
		return $this->main->setData( $this->model );
	}
	function insertAction() {
		if ( $this->model->insert($this->post) ) {
			return $this->getMessageCode('saved');
		}
		return $this->getMessageCode('saveFailed');
	}
	function updateAction() {
		if ( $this->model->update($this->post) ) {
			return $this->getMessageCode('updated');
		}
		return $this->getMessageCode('updateFailed');
	}
	function deleteAction() {
		if ( $this->model->delete( $get->idx ) ) {
			return $this->getMessageCode('deleted');
		}
		return $this->getMessageCode('deleteFailed');
	}
	function getMessageCode( $code ) {
		return MadMessageCodeManager::getInstance()->$code();
	}
}

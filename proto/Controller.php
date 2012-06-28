<?='<?' . "\n"?>
class <?=$config->name?>Controller extends MadController {
	function __construct() {
		parent::__construct();
		$this->model = new <?=$config->name?>;
	}
	function indexAction() {
	}
	function listAction() {
		$list = new <?=$config->name?>List($this->model);
		$view = new MadView;
		$view->list = $list;
		return $view;
	}
	function writeAction() {
		$this->model->fetch( $this->get->no );
		$form = new MadForm( $this->model );
		$view = new MadView;
		$view->form = $form;
		$view->model = $this->model;
		return $view;
	}
	function viewAction() {
		$this->model->fetch( $this->get->no );
		$view = new MadView;
		$view->model = $this->model;
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

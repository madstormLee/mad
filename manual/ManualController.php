<?
class ManualController extends MadController {
	function indexAction() {
	}
	function listAction() {
		$get = $this->params;
		if ( empty( $get->domain ) ) {
			$get->domain = '/mad/tools';
		}
		$model = $this->model;
		$model->setDomain( $get->domain );
	}
	function viewAction() {
		$get = $this->params;
		$model = $this->model;
		$model->fetch( $get->id );

		//todo if right used.
		$list = new Manual( "manual.json" );

		$this->view->view = new MadView( "$params->id.html" );
	}
	function manualAction() {
		$get = $this->params;
		$model = new FileManual( $get->file );

		$this->view->model = $model;
	}
	function writeAction() {
		$get = $this->params;
		$this->js->add('~/venders/ckeditor/ckeditor.js');
		$this->view->model = new Manual( $this->params->id );
	}
	function saveAction() {
	}
	function deleteAction() {
		return $this->model->delete( $this->params->file );
	}
}

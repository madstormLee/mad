<?
class AutosaveController extends MadController {
	function indexAction() {
		$get = $this->params;
		if ( ! $get->interval ) {
			$get->interval = 60;
		}
		$model = $this->model;
		$model->setInterval( $get->interval );
		$this->view->params = $this->params;
	}
	function viewAction() {
		return $this->model->formData;
	}
	function saveAction() {
		$model = $this->model;
		$model->formData = $this->params->json();
		return $model->save();
	}
	function deleteAction() {
		$this->model->delete();
		return '{}';
	}
}

<?
class ProjectController extends MadController {
	function indexAction() {
	}
	function listAction() {
	}
	function viewAction() {
		$this->model->fetch( $this->params->id );
	}
	function writeAction() {
		$this->model->fetch( $this->params->id );
	}
	function saveAction() {
		return $this->model->setData( $this->params )->save();
	}
	function deleteAction() {
		$dir = new MadDir( $this->params->id );
		return $dir->deleteAll();
	}
	function openAction() {
		$project = $this->model->fetch( $this->params->id );
		return $this->session->set('project', $project )->__isset('project');
	}
	function closeAction() {
		return $this->session->__unset( 'project' );
	}
	function downloadAction() {
		$get = $this->params;
		$targetDir = "project/download/";
		$model = $this->model;
		$model->setData( $get );

		MadHeaders::download( $get->project . $this->ext );
		print $model->getContents();
		die;
	}
}

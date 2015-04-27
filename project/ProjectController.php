<?
class ProjectController extends MadController {
	function indexAction() {
	}
	function viewAction() {
		$this->model->fetch( $this->params->id );
	}
	function writeAction() {
		$this->model->fetch( $this->params->id );
	}
	// todo: from XP
	function saveProjectAction() {
		$post = MadParams::create('post');
		$fileName = "project/data/$post->title.json";
		$json = new MadJson($fileName);
		$post->item->filter();
		$json->setData( $post );
		return $json->save();
	}
	function saveAction() {
		$post = $this->params;
		$model = $this->model;

		$model->setData( $post );
		return $model->save();
	}
	function deleteAction() {
		$dir = new MadDir( $this->params->id );
		return $dir->deleteAll();
	}
	function openAction() {
		$session = MadSession::getInstance();
		return $session->set('project', $this->params->id );
	}
	function closeAction() {
		$session = MadSession::getInstance();
		unset( $session->project );
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

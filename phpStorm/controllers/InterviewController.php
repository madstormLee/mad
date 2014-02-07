<?
class InterviewController extends Preset {
	function __construct() {
		parent::__construct();
		$this->model = new Interview;
	}
	function indexAction() {
		$this->main->dir = $this->model->getFiles();
		return $this->main;
	}
	function analyzeAction() {
		$this->main->model = $this->model->setFile( $this->get->file );
		$this->right->setView('views/Interview/right');
		return $this->main;
	}
	function readAction() {
		$this->js->add('/nomad/ckeditor/ckeditor');
		$this->main->model = $this->model->setFile( $this->get->file );
		return $this->main;
	}
	function updateAction() {
		$post = $this->post;
		$this->model->setFile( $post->file )
			->setContent( $post->content )
			->save();
		$this->js->replace( './index' );
	}
	function deleteAction() {
		$this->model->delete( $this->get->file );
		$this->js->replace( './index' );
	}
}

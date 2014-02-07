<?
class FileManualController extends MadController {
	private $dir = 'data/FileManual';

	function indexAction() {
		$list = new FileManual( "/index.html" );
		$this->main->list = $list;
	}
	function viewAction() {
		$get = $this->get;

		$this->js->addNext("http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js", 'jquery');

		// $this->right->setView( 'views/FileManual/viewRight.html' );
		// $this->right->list = $model->getTree();

		$model = new FileManual( $get->file );

		$this->main->model = $model;
	}
	function writeAction() {
		$get = $this->get;
		$this->js->add('~/venders/ckeditor/ckeditor.js');

		$this->main->view = new MadView( $this->dir . "/$get->id.html" );
	}
	function saveAction() {
		$post = $this->post;
		$model = new FileManual( $post->file );
		$model->saveManual( $post->contents );

		$this->js->replace('./view?file=' . $post->file );
	}
	function downloadAction() {
	}
}

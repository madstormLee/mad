<?
class ManualController extends MadController {
	function indexAction() {
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

		$this->right->setView( 'FileManual/viewRight.html' );
		$this->right->list = $model->getTree();

		$model = new FileManual( $get->file );

		$this->view->model = $model;
	}
	function writeAction() {
		$get = $this->params;
		$this->js->add('~/venders/ckeditor/ckeditor.js');
		$this->view->model = new Manual( $this->params->id );
	}
	function saveAction() {
		$post = $this->params;

		$list = new Manual( "/manual.json" );

		$view = new MadView( "/$this->l10n/{$post->id}.html" );
		$view->saveContents( $post->contents );

		$list->rescan()->save();

		$this->js->replace('./view?id=' . $post->id );
	}
	function deleteAction() {
		return $this->model->delete( $this->params->file );
	}
}

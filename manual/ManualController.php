<?
class ManualController extends MadController {
	function indexAction() {
		$list = new MadManual( "manual.json" );
		$this->main->list = $list;
	}
	function viewAction() {
		$this->js->addNext("http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js", 'jquery');

		$model = new Manual( $this->get->id );
		$this->main->model = $model;

		//todo if right used.
		$list = new MadManual( "manual.json" );
		$this->right->setView( 'views/Manual/viewRight.html' );
		$this->main->list = new ManualList;
		$this->right->list = $list;

		$this->main->view = new MadView( "$get->id.html" );
	}
	function writeAction() {
		$this->js->add('~/venders/ckeditor/ckeditor.js');
		$model = new Manual( $this->get->id );
		$this->main->model = $model;
		//todo this not right. use fileManual
		$this->main->view = new MadView( "$get->id.html" );
	}
	function saveAction() {
		$post = $this->post;

		$list = new Manual( "/$this->l10n/manual.json" );

		$view = new MadView( "/$this->l10n/{$post->id}.html" );
		$view->saveContents( $post->contents );

		$list->rescan()->save();

		$this->js->replace('./view?id=' . $post->id );
	}
	function deleteAction() {
	}
}

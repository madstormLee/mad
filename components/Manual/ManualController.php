<?
// this controller and models assume you have no database or anything but file system.
class ManualController extends MadController {
	private $dir = 'data/Manual';

	function indexAction() {
		$list = new MadManual( $this->dir . "/$this->l10n/manual.json" );
		$this->main->list = $list;
	}
	function viewAction() {
		$this->js->addNext("http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js", 'jquery');

		$model = new Manual( $this->get->id );
		$this->main->model = $model;

		//todo if right used.
		$list = new MadManual( $this->dir . "/$this->l10n/manual.json" );
		$this->right->setView( 'views/Manual/viewRight.html' );
		$this->main->list = new ManualList;
		$this->right->list = $list;

		$file = $this->dir . "/$this->l10n/$get->id.html";
		$this->main->view = new MadView( $file );
	}
	function writeAction() {
		$this->js->add('~/venders/ckeditor/ckeditor.js');
		$model = new Manual( $this->get->id );
		$this->main->model = $model;
		//todo this not right. use fileManual
		$this->main->view = new MadView( $this->dir . "/$this->l10n/$get->id.html" );
	}
	function saveAction() {
		$post = $this->post;

		$list = new MadManual( $this->dir . "/$this->l10n/manual.json" );

		$view = new MadView( $this->dir . "/$this->l10n/{$post->id}.html" );
		$view->saveContents( $post->contents );

		$list->rescan()->save();

		$this->js->replace('./view?id=' . $post->id );
	}
	function deleteAction() {
	}
	function downloadAction() {
	}
	function __call( $method, $args ) {
	}
}

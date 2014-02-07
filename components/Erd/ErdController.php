<?
class ErdController extends MadController {
	function indexAction() {
		$list = new MadFile('data/Erd');
		$list->filter('^\.');
		$this->main->list = $list;
	}
	function writeAction() {
		$this->js->addNext("http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js", 'jquery');
		$this->right = new MadView('views/Erd/right.html');

		$model = new Erd( $this->get->file );

		$this->main->model = $model;
	}
	function viewAction() {
		$model = new Erd( $this->get->file );
		$this->main->model = $model;
	}
	function saveAction() {
		$post = $this->post;
		if ( $file = ! $post->file ) {
			$file = "data/Erd/$post->title.json";
		}
		$model = new Erd( $file );
		$model->setData( $post );
		return $model->save();
	}
	function editAction() {
	}
}

<?
class ClassDiagramController extends MadController {
	function indexAction() {
		$list = new MadFile('data/ClassDiagram');
		$list->filter('^\.');
		$this->main->list = $list;
	}
	function writeAction() {
		$this->layout->setView('views/layouts/write.html');
		$this->js->addNext("http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js", 'jquery');
		$this->right = new MadView( 'views/ClassDiagram/right.html' );

		$model = new ClassDiagram( $this->get->file );

		$this->main->model = $model;
	}
	function viewAction() {
		$model = new ClassDiagram( $this->get->file );
		$this->main->model = $model;
	}
	function saveAction() {
		$post = $this->post;
		if ( $file = ! $post->file ) {
			$file = "data/ClassDiagram/$post->title.json";
		}
		$model = new ClassDiagram( $file );
		$model->setData( $post );
		return $model->save();
	}
	function deleteAction() {
		return $this->model->delete( $this->get->id );
	}
}

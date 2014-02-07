<?
class ComponentDiagramController extends MadController {
	function indexAction() {
		$list = new MadFile('data/ComponentDiagram');
		$list->filter('^\.');
		$this->main->list = $list;
	}
	function writeAction() {
		$this->js->addNext("http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js", 'jquery');
		$this->right = new MadView( 'views/ComponentDiagram/right.html' );

		$model = new ComponentDiagram( $this->get->file );
		$this->main->model = $model;
	}
	function viewAction() {
		$model = new ComponentDiagram( $this->get->file );
		$this->main->model = $model;
	}
	function saveAction() {
		$post = $this->post;
		if ( $file = ! $post->file ) {
			$file = "data/ComponentDiagram/$post->title.json";
		}
		$model = new ComponentDiagram( $file );
		$model->setData( $post );
		return $model->save();
	}
	function deleteAction() {
	}
}

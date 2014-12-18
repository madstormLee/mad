<?
class ComponentDiagramController extends MadController {
	function indexAction() {
		$list = new MadFile('data/ComponentDiagram');
		$list->filter('^\.');
		$this->main->list = $list;
	}
	function writeAction() {
		$this->js->addNext("//ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js", 'jquery');
		$this->right = new MadView( 'ComponentDiagram/right.html' );

		$model = new MadJson( $this->get->file );
		$this->main->model = $model;
	}
	function viewAction() {
		$model = new MadJson( $this->get->file );
		$this->main->model = $model;
	}
	function deleteAction() {
	}
}

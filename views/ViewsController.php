<?
class ViewsController extends MadController {
	function viewAction() {
		$path = $this->params->path . '.html';
		$this->view->setView( $path );
	}
}

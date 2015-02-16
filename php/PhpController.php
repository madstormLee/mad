<?
class PhpController extends MadController {
	function indexAction() {
	}
	function infoAction() {
		$model = $this->model;
		$get = $this->params;
		if ( $get->options ) {
			$model->setOption( $get->options );
		}
		$this->view->option = $get->option;
	}
}

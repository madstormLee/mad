<?
class ImagesController extends MadController {
	function indexAction() {
		$get = $this->params;
		if( ! $get->dir ) {
			$get->dir = 'images';
		}
		$this->model->setDir( $get->dir );
	}
	function viewAction() {
		$file = new MadFile( $this->params->file );
		$this->view->file = $file;
		$this->view->info = $file->getInfo();
	}
}

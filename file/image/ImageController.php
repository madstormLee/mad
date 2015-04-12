<?
class ImageController extends MadController {
	function indexAction() {
		$get = $this->params;
		if( ! $get->dir ) {
			$get->dir = 'file/image';
		}
		$this->view->index = new MadDir( $get->dir, '*.{gif,png,jpg}' );
	}
	function viewAction() {
		$file = new MadFile( $this->params->file );
		$this->view->file = $file;
		$this->view->info = $file->getInfo();
	}
}

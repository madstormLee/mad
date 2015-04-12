<?
class JsonController extends MadController {
	function indexAction() {
		$this->view->setFile( 'file/index.html' );
		$this->model->h1 = 'Json Index';
	}
	function writeAction() {
		if ( ! is_file( $this->params->file ) ) {
			throw new Exception('File not found.');
		}
		
		$this->view->model = $this->model->load( $this->params->file );
	}
	function saveAction() {
		$post = $this->post;
		$model = new MadJson( $post->file );
		$model->setFromDl( $post->data );
		return $this->model->save();
	}
	function viewAction() {
		if ( ! is_file( $this->params->file ) ) {
			throw new Exception('File not found.');
		}
		
		$this->model->load($this->params->file );
	}
	function viewRawAction() {
		if ( ! is_file( $this->params->file ) ) {
			throw new Exception('File not found.');
		}
		
		$this->view->data = $this->model->load( $this->params->file );
	}
}

<?
class ImageController extends MadController {
	function indexAction() {
		$router = $this->router;
		// printR( $router );
		$options = array(
			'script_url' => "http://$router->host/$router->project/image/",
			'upload_dir' => 'image/',
			'upload_url' =>  "http://$router->host/$router->project/image/",
		);
		// printR( $options ); 
	}
	function listAction() {
		$get = $this->params;
		if( ! $get->dir ) {
			$get->dir = 'file/image/data';
		}
		$this->view->index = new MadDir( $get->dir, '*.{gif,png,jpg}' );
	}
	function saveAction() {
		$router = $this->router;
		error_reporting(E_ALL | E_STRICT);
		include __dir__ . '/UploadHandler.php';
		$options = array(
			'script_url' => "$router->project/image/",
			'upload_dir' => 'files/',
			// 'upload_url' =>  "$router->project/image/",
			'upload_url' =>  "/mad/files/",
		);
		$upload_handler = new UploadHandler( $options );
		die;
	}
	function viewAction() {
		$file = new MadFile( $this->params->file );
		$this->view->file = $file;
		$this->view->info = $file->getInfo();
	}
}

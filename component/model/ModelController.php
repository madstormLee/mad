<?
class ModelController extends MadController {
	function indexAction() {
		$get = $this->params;
		if ( ! isset( $get->dir ) ) {
			$get->dir = 'model';
		}
		$dir = new MadFile( $get->dir );

		$data = new MadData;
		foreach( $dir as $row ) {
			$data[] = new Model( $row );
		}

		$this->view->index = $data;
	}
}

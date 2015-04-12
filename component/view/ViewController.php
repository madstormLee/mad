<?
class ViewController extends MadController {
	function indexAction() {
	}
	function indexViewAction() {
		$get = $this->params;
		if ( ! is_file( $get->id ) ) {
			throw new Exception('no model like ' . $get->id);
		}
		$this->view->index = new MadList( new $get->id );
	}
	function viewAction() {
		$file = $this->get->file;
		if ( ! is_file( $file ) ) {
			return new Exception('fileNotFound');
		}

		return file_get_contents( $file );

		$html = "file doesn't exists";
		$target = ROOT . $_SERVER['REQUEST_URI'];
		if ( is_file( $target ) ) {
			$escapes = array( 
				'<?' => '&lt;?',
				'?>' => '?&gt;',
				);
			$html = str_replace( array_keys( $escapes ), array_values( $escapes ),  file_get_contents( $target ) );
		}
		return $html;
	}
	function viewAction() {
	}
}

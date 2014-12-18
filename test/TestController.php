<?
class TestController extends MadController {
	function indexAction() {
		$this->view->list = new MadDir( 'Test/data' );
	}
	function writeAction() {
	}
	function viewAction() {
		$get = $this->get;
		if ( ! is_file( $get->file ) ) {
			throw new Exception( 'File not found!' );
		}
		include_once $get->file;
		$className = basename( $get->file , '.php' );

		$test = new $className;

		$this->view->test = $test;
	}
}

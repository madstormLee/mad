<?
class TestController extends MadController {
	function indexAction() {
		$list = new MadFile( 'tests' );
		$list->filter('^\.');
		$this->main->list = $list;
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

		$this->main->test = $test;
	}
}

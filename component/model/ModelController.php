<?
class ModelController extends MadController {
	function indexAction() {
		$get = $this->params;
	}
	function presetAction() {
	}
	function writeAction() {
		$get = $this->params;
		if ( 0 === strpos($get->file, '/') ) {
			$get->file = $this->router->document . $get->file;
		}
		$this->fetch( $get->file );
	}
}

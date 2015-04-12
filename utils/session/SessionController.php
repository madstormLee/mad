<?
class SessionController extends MadController {
	function indexAction() {
	}
	function writeAction() {
	}
	function saveAction() {
	}
	function setAction() {
		foreach( $this->get as $key => $value ) {
			$_SESSION[$key] = $value;
		}
		$this->js->replaceBack();
	}
	function unsetAction() {
		$this->get->test();
		unset( $_SESSION[$this->get->{0}] );
	}
}

<?
class WindowController extends Preset {
	function indexAction() {
		return new Window( $this->get );
	}
}

<?
class ControllerController extends MadController {
	function indexAction() {
		$list = new MadFile( $this->projectLog->root . $this->projectLog->configs->dirs->controllers );
		$list->filter('^\.');

		$this->main->list = $list;
	}
}

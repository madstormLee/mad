<?
class IndexController extends Preset {
	function indexAction() {
		// $this->main->openedProjects = $this->phpStorm->getOpenedProject();
		$this->main->openedProjects = array();
		return $this->main;
	}
}

<?
// download: wget tools.madstorm.org/ghost/download?id=madstorm
// secure unlock: tools.madstorm.org/ghost/unlock?id=madstorm
class GhostController extends MadController {
	function indexAction() {
		$this->main->ghost = new Ghost('ts');
	}
	function unlockAction() {
	}
	function lockAction() {
	}
	function selectAction() {
	}
	function downloadAction() {
	}
}

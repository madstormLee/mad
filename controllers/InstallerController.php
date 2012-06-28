<?
class InstallerController extends MadController {
	function __construct() {
		parent::__construct();
		$installer = new MadInstaller();
	}
	function indexAction() {
	}
	function connAction() {
		$this->setFront(MadController::MAINONLY_LAYOUT);
	}
}

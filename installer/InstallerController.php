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
	function downloadAction() {
		$get = $this->params;
		$targets = array(
			'madtools' => MADTOOLS . 'madtools.php',
			'command' => 'configs/Installer/commands.json',
			'errors' => 'configs/Installer/errors.json',
		);
		if ( ! in_array( $get->target, $targets ) ) {
			return false;
		}
		return file_get_contents( $targets[$get->target] );
	}
}

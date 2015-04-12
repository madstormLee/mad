<?
class InstallerController extends MadController {
	function indexAction() {
	}
	function connAction() {
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

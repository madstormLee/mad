<?
class HelpController extends Preset {
	function indexAction() {
		ob_start();
		phpinfo();
		$rv = ob_get_clean();
		return $rv;
	}
}

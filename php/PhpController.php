<?
class PhpController extends MadController {
	function indexAction() {
	}
	function infoAction() {
		$this->view->list = new MadJson('Phpinfo/options.json');
		$params = $this->params;
		if ( ! $params->option ) {
			$params->option = INFO_GENERAL;
		}
		$this->view->option = $params->option;
	}
}

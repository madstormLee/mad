<?
class IndexController extends MadController {
	function indexAction() {
		return 'tested';
	}
	function temp() {
		$model = new FileX;
		$window = new MadWindow;
		$this->main->window = $window;
		return $this->main;
	}
}

<?
class IndexController extends Preset {
	function __construct() {
		parent::__construct();
		$this->model = new FileX;
	}
	function indexAction() {
		$model = new FileX;
		$window = new MadWindow;
		$this->main->window = $window;
		return $this->main;
	}
}

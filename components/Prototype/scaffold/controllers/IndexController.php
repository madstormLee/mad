<?
class IndexController extends MadController {
	function __construct() {
		parent::__construct();
		$this->model = new mad;
		$this->get = new MadData($_GET);
		$this->post = new MadData($_POST);
	}
	function indexAction() {
		return 'indexController/indexAction';
	}
}

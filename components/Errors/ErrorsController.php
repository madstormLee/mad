<?
class ErrorsController extends MadController {
	function __construct() {
		parent::__construct();
		$this->main = 'error controller';
	}
	function indexAction() {
		$this->left = '';
		$this->main = 'error controller';
	}
	function unauthAction() {
		return false;
	}
	function pageNotFoundAction() {
		$controller = $_GET['controller'];
		$action = $_GET['action'];
		$this->main = "/$this->project/$controller/$action Page Not Founded.";
	}
}

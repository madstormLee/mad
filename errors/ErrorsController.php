<?
class ErrorsController extends MadController {
	function pageNotFoundAction() {
		$controller = $_GET['controller'];
		$action = $_GET['action'];
		$this->main = "/$this->project/$controller/$action Page Not Founded.";
	}
}

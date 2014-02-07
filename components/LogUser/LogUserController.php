<?
class LogUserController extends MadController {
	function loginAction() {
		$this->layout->setView('views/layouts/mainOnly.html');
		$this->css->clear()->add("~/css/$this->controllerName/$this->actionName.css");
	}
	function addRoleAction() {
		$post = $this->post;
		$log = $this->log->login( $post );
		$this->js->alert( "you logged in as $log->label" )->replace('~/');
	}
	function logoutAction() {
		$this->log->logout();
		$this->js->replace('./login');
	}
}

<?
class ApiController extends MadController {
	function indexAction() {
		$data = $this->model->getList();
		if ( $callback = htmlspecialchars(strip_tags($this->get->callback)) ) {
			return $this->jsonpAction();
		}
		return $data->json();
	}
	function jsonpAction() {
		$get = $this->get;
		header("Content-Type: text/javascript; charset=utf-8");
		$data = $this->model->getList();

		if ( ! $callback = htmlspecialchars(strip_tags($get->callback)) ) {
			return '{}';
		}
		return $callback.'('.$data->json().')';
	}
	function resourceAction() {
		header("Content-Type: text/html;charset=utf-8");
		return printR( $this->model->getList()->getArray(), true );
	}
	// this will override.
	function __call( $method, $args ) {
		return $this->indexAction();
	}
}

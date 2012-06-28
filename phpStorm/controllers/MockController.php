<?
class MockController extends MadController {
	function __construct() {
		parent::__construct();
		$this->model = new MadMock;
	}
	function insertAction() {
		$this->model->setTable( $this->get->table )
			->setRows( $this->post->rows )
			->create();
		$q = new Q( $this->model );
		return $q->rows();
	}
}

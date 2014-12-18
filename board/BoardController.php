<?
class BoardController extends MadController {
	function indexAction() {
		$tail = $this->params->tail;
		$this->table = 'MadBoard_'.$tail;
	}
	function saveAction() {
		if ( ! $this->userLog->isLogin() ) {
			return false;
		}
		$rv = 0;
		$no = $_SESSION[$this->table]['currentEditingNo'];

		$post = $this->post;
		$post->articleLevel = 255;

		$model = new Board;
		$model->save( $post );

		$this->main = $rv;
	}
	function deleteAction() {
		$no = $this->get->no;
		if ( $q->rows() < 1 ) {
		}
	}
}

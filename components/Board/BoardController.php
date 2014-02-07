<?
class BoardController extends MadController {
	public function __construct() {
		parent::__construct();
		$this->madlog = MadLog::getInstance('user');
		$this->setFront(MadController::MAINONLY_LAYOUT);
		$tail = $this->get->tail;
		$this->table = 'MadBoard_'.$tail;
	}
	public function saveAction() {
		if ( ! $this->madlog->isLogin() ) {
			print 0;
			die;
		}
		$rv = 0;
		$no = $_SESSION[$this->table]['currentEditingNo'];

		$post = $this->post;
		$post->articleLevel = 255;

		$model = new Board;
		$model->save( $post );

		$this->main = $rv;
	}
	public function delAction() {
		$no = $this->get->no;
		if ( ! $this->madlog->isLogin() ) {
			$this->js->replace('/main/error/illegalAccess');
		}
		if ( $this->madlog->isAdmin() ) {
			$query = "delete from $this->table where no=$no limit 1";
		} else {
			$id = $this->madlog->getUserId();
			$query = "delete from $this->table where no=$no and id=$id limit 1";
		}
		$q = new Q($query);
		if ( $q->rows() < 1 ) {
			$this->js->alert('??力?婪? ?源洗?.', 'back', 'replace');
		} else {
			$this->js->alert('??力?蔷??来洗?.', 'back', 'replace');
		}
	}
}

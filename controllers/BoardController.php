<?
class BoardController extends MadController {
	public function __construct() {
		parent::__construct();
		$this->madlog = MadLog::getInstance('user');
		$this->setFront(MadController::MAINONLY_LAYOUT);
		$tail = ckGet('tail');
		$this->table = 'MadBoard_'.$tail;
	}
	public function saveAction() {
		if ( ! $this->madlog->isLogin() ) {
			print 0;
			die;
		}
		$rv = 0;
		$no = $_SESSION[$this->table]['currentEditingNo'];

		$set = new MadSet(sqlin($_POST));
		$set->articleLevel = 255;
		$query = "update $this->table $set where no=$no limit 1";
		$q = new Q($query);
		if ( $q->rows() > 0 ) {
			$rv = '����Ǿ����ϴ�.';
		} else {
			$rv = '�ڵ����� : ���� ������ �����ϴ�.';
		}
		$this->main = $rv;
	}
	public function delAction() {
		$no = ckGet('no');
		if ( ! $this->madlog->isLogin() ) {
			replace('/main/error/illegalAccess');
		}
		if ( $this->madlog->isAdmin() ) {
			$query = "delete from $this->table where no=$no limit 1";
		} else {
			$id = $this->madlog->getUserId();
			$query = "delete from $this->table where no=$no and id=$id limit 1";
		}
		$q = new Q($query);
		if ( $q->rows() < 1 ) {
			alert('�������� �Դϴ�.', 'back', 'replace');
		} else {
			alert('�����Ǿ����ϴ�.', 'back', 'replace');
		}
	}
}

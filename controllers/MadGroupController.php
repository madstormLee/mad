<?
class MadGroupController extends MadController {
	private $table;
	private $tail = '';
	private $group;

	function __construct() {
		parent::__construct();
		$this->setFront(MadController::MAINONLY_LAYOUT);
		$this->table = $this->controller;
		if( $tail = ckGet('tail') ) {
			$this->tail = $tail;
			$this->table .= '_'.$tail;
		}
		$era = '';
		if ( $tail == 'task' ) {
			$era = Era::getInstance();
			$this->table = $era . '.' . $this->table;
		}
		$this->group = new MadGroup($this->tail, $era);
	}
	function listAction() {
	}
	function getSubGroupAction() {
		$relNo = $_POST['relNo'];
		$this->madArr = $this->group->getSub($relNo);
	}
	private function getOrderNo($no) {
		$orderNo = 1;
		$query = "select orderNo from $this->table where no = $no limit 1";
		$q = new Q ( $query );
		$orderNo = $q->getFirst();

		return $orderNo;
	}
	public function toUpAction() {
		$no = ckPost('no');
		$relNo = ckPost('relNo');
		$orderNo = $this->getOrderNo($no);
		$target = $orderNo-1;

		$query = "update $this->table set orderNo=orderNo + 1
			where relNo=$relNo and orderNo=$target limit 1";
		$q = new Q ( $query );
		if ( $q->rows() > 0 ) {
			$query = "update $this->table set orderNo=orderNo - 1
				where relNo=$relNo and no=$no limit 1";
			$q = new Q ( $query );
		}
		$this->main = $q->rows();
	}
	public function toDownAction() {
		$no = $_POST['no'];
		$relNo = $_POST['relNo'];
		$orderNo = $this->getOrderNo($no);
		$target = $orderNo+1;

		$query = "update $this->table set orderNo=orderNo - 1
			where relNo=$relNo and orderNo=$target limit 1";
		$q = new Q ( $query );
		if ( $q->rows() > 0 ) {
			$query = "update $this->table set orderNo=orderNo + 1
				where no=$no limit 1";
			$q = new Q ( $query );
		}
		$this->main = $q->rows();
	}
	public function insAction() {
		$relNo = ckPost('relNo');
		if ( $relNo === false ) {
			print 0;
			die;
		}
		$orderNo = 0;
		$query = "select max(orderNo) from $this->table where relNo=$relNo";
		$q = new Q($query);
		if ( $q->rows() > 0 ) {
			$orderNo = $q->getFirst() + 1;
		}

		$name = '새로운 그룹';
		$this->table;
		$query = "insert into $this->table set name='$name',relNo=$relNo,orderNo=$orderNo";
		$q = new Q($query);
		$this->no = $q->getInsertId();
		$this->name = $name;
	}
	public function upAction() {
		if ( ! isset($_POST['no']) ) {
			print 0;
			die;
		}
		$no = ckPost('no');
		$post = $_POST;
		$set = new MadSet($post);
		$set->remove('no');
		$set->decode();

		$query = "update $this->table $set where no=$no limit 1";
		$q = new Q($query);
		$this->main = $q->rows();
	}
	public function delAction() {
		if ( ! $no = ckPost('no') ) {
			print 0;
			die;
		}
		$orderNo = $this->getOrderNo($no);
		$relTeams = Q::total($this->table, "relNo = $no");
		if ( $relTeams > 0 ) {
			print $relTeams . '개의 하위 그룹이 존재합니다.';
			die;
		}
		$query = "delete from $this->table where no=$no limit 1";
		$q = new Q($query);
		$this->main = $q->rows();

		$relNo = $this->group->getRelNo( $no );
		if ( $q->rows() > 0 ) {
			$query = "update $this->table set orderNo=orderNo-1 where relNo = $relNo and orderNo>$orderNo";
			$q = new Q($query);
		}
		// 나중에 tail별로 extends한 파일을 만든다.
		if ( $this->tail == 'task' ) {
			$taskUser = new TaskUser;
			$taskUser->deleteNo($no);
		}
	}
}

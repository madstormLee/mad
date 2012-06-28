<?
class GroupController extends MadController {
	private $table;
	private $tail = '';

	function __construct() {
		parent::__construct();
		$this->setFront(MadController::MAINONLY_LAYOUT);
		$this->table = 'MadGroup';
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
	function selectFormAction() {
		$this->main->id = ckPost('id') . 'Selector';
		$tuple = $this->group->getTree();
		$this->main->innerForm = $this->dlTree($tuple);
	}
	function selectorAction() {
		$tuple = $this->group->getTree();
		$this->tuple = $tuple;
	}
	private function dlTree($tuple) {
		$rv = "<dl>";
		foreach( $tuple as $no => $row ) {
			extract($row);
			$rv .= "<dt><a href='?no=$no'>$name</a></dt>";
			if ( ! empty($row['subTree']) ) {
				$rv .= '<dd style="display: none">';
				$rv .= $this->dlTree( $row['subTree'] );
				$rv .= '</dd>';
			}
		}
		$rv .= "</dl>";
		return $rv;
	}
	function getSubSelectAction() {
		$rv = "<option value='0'>섹션 선택</option>";
		$no = ckGet('no');
		if ( $no == 0 ) {
			print $rv;
			die;
		}
		$section = new MadGroup('gallerySection');
		$sub = $section->getSub($no);
		foreach ( $sub as $row ) {
			extract($row);
			$rv .= "<option value='$no'>$name</option>";
		}
		$this->main = $rv;
	}

	function getSubGroupAction() {
		$relNo = $_POST['relNo'];
		$this->madArr = $this->group->getSub($relNo);
	}
	public function toUpAction() {
		$no = $_POST['no'];
		$relNo = $_POST['relNo'];
		$query = "update $this->table set orderNo = orderNo - 1
			where no = $no limit 1";
		$q = new Q ( $query );
		$rows = $q->rows();
		print $rows;

		$query = "select orderNo from $this->table where no = $no limit 1";
		$q = new Q ( $query );

		$orderNo = $q->getFirst();
		$query = "update $this->table set orderNo = orderNo + 1
			where relNo = $relNo and orderNo >= $orderNo and no <> $no";
		$q = new Q ( $query );
		die;
	}
	public function toDownAction() {
		$no = $_POST['no'];
		$relNo = $_POST['relNo'];
		$query = "update $this->table set orderNo = orderNo + 1
			where no = $no limit 1";
		$q = new Q ( $query );
		$rows = $q->rows();
		print $rows;

		$query = "select orderNo from $this->table where no = $no limit 1";
		$q = new Q ( $query );

		$orderNo = $q->getFirst();
		$query = "update $this->table set orderNo = orderNo - 1
			where relNo = $relNo and orderNo <= $orderNo and no <> $no";
		$q = new Q ( $query );
		die;
	}
	public function insAction() {
		if ( ! isset($_POST['relNo']) ) {
			print 0;
			die;
		}
		$relNo = $_POST['relNo'];
		$query = "select max(orderNo) from $this->table where relNo=$relNo";
		$name = $this->name = '새로운 그룹';
		$query = "insert into $this->table set name='$name', relNo=$relNo";
		$q = new Q($query);
		$this->no = $q->getInsertId();
	}
	public function upAction() {
		if ( ! isset($_POST['no']) ) {
			print 0;
			die;
		}
		$no = $_POST['no'];
		$post = $_POST;
		$set = new MadSet($post);
		$set->remove('no');

		$query = "update $this->table $set where no=$no limit 1";
		$q = new Q($query);
		print $q->rows();
		die;
	}
	public function delAction() {
		if ( ! isset($_POST['no']) ) {
			print 0;
			die;
		}
		$no = $_POST['no'];
		$relTeams = Q::total($this->table, "relNo = $no");
		if ( $relTeams > 0 ) {
			print $relTeams . '개의 하위 그룹이 존재합니다.';
			die;
		}
		$query = "delete from $this->table where no=$no limit 1";
		$q = new Q($query);
		print $q->rows();
		die;
	}
}

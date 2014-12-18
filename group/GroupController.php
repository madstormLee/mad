<?
class GroupController extends MadController {
	private $table;
	private $tail = '';
	private $group;

	function __construct() {
		parent::__construct();
		$this->setFront(MadController::MAINONLY_LAYOUT);
		$this->table = $this->controllerName;
		if( $tail = $this->get->tail ) {
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
		$post = $this->post;
		$this->main->id = $post->id . 'Selector';
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
		$rv = "<option value='0'>???? ????</option>";
		$no = $this->get->no;
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
	private function getOrderNo($no) {
		$orderNo = 1;
		$query = "select orderNo from $this->table where no = $no limit 1";
		$q = new Q ( $query );
		$orderNo = $q->getFirst();

		return $orderNo;
	}
	public function toUpAction() {
		$post = $this->post;
		$orderNo = $this->getOrderNo($post->no);
		$target = $orderNo-1;

		$query = "update $this->table set orderNo=orderNo + 1
			where relNo=$post->relNo and orderNo=$target limit 1";
		$q = new Q ( $query );
		if ( $q->rows() > 0 ) {
			$query = "update $this->table set orderNo=orderNo - 1
				where relNo=$post->relNo and no=$post->no limit 1";
			$q = new Q ( $query );
		}
		$this->main = $q->rows();
	}
	public function toDownAction() {
		$post = $this->post;
		$orderNo = $this->getOrderNo($post->no);
		$target = $orderNo+1;

		$query = "update $this->table set orderNo=orderNo - 1
			where relNo=$post->relNo and orderNo=$target limit 1";
		$q = new Q ( $query );
		if ( $q->rows() > 0 ) {
			$query = "update $this->table set orderNo=orderNo + 1
				where no=$post->no limit 1";
			$q = new Q ( $query );
		}
		$this->main = $q->rows();
	}
	public function insAction() {
		$post = $this->post;
		if ( $post->relNo === false ) {
			print 0;
			die;
		}
		$orderNo = 0;
		$query = "select max(orderNo) from $this->table where relNo=$post->relNo";
		$q = new Q($query);
		if ( $q->rows() > 0 ) {
			$orderNo = $q->getFirst() + 1;
		}

		$name = '???Î¿? ?×·?';
		$this->table;
		$query = "insert into $this->table set name='$name',relNo=$post->relNo,orderNo=$orderNo";
		$q = new Q($query);
		$this->no = $q->getInsertId();
		$this->name = $name;
	}
	public function upAction() {
		$post = $this->post;
		if ( $post->no ) {
			return 0;
		}
		$post = $_POST;
		$set = new MadSet($post);
		$set->remove('no');
		$set->decode();

		$query = "update $this->table $set where no=$post->no limit 1";
		$q = new Q($query);
		$this->main = $q->rows();
	}
	public function delAction() {
		$post = $this->post;
		if ( ! $post->no ) {
			return 0;
		}
		$orderNo = $this->getOrderNo($post->no);
		$relTeams = Q::total($this->table, "relNo = $post->no");
		if ( $relTeams > 0 ) {
			print $relTeams . '???? ??À§ ?×·??? Á¸???Õ´Ï´?.';
			die;
		}
		$query = "delete from $this->table where no=$post->no limit 1";
		$q = new Q($query);
		$this->main = $q->rows();

		$relNo = $this->group->getRelNo( $post->no );
		if ( $q->rows() > 0 ) {
			$query = "update $this->table set orderNo=orderNo-1 where relNo = $relNo and orderNo>$orderNo";
			$q = new Q($query);
		}
		// ???ß¿? tail???? extends?? ????À» ??????.
		if ( $this->tail == 'task' ) {
			$taskUser = new TaskUser;
			$taskUser->deleteNo($no);
		}
	}
}

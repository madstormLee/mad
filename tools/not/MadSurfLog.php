<?
class MadSurfLog {
	private $className;
	private $table;

	function __construct(){
		$this->className = __class__;
		$this->table = __class__;
		$this->sess = new MadSession($this->className);
		if ( (! isset( $this->sess->currentPage ) ) || $this->sess->currentPage != $_SERVER['REQUEST_URI'] ) {
			$this->ins();
		}
	}
	private function getRelNo() {
		$counter = new MadSession('MadCounter');
		return $counter->id;
	}
	function ins() {
		$relNo = $this->getRelNo();
		$page = $_SERVER['REQUEST_URI'];

		$values = compact('relNo','page');

		$set = new MadSet($values);
		$query = "insert into $this->table $set";
		$q = new Q($query);
		if ( $q->rows() > 0 ) {
			$this->sess->currentPage = $page;
		}
	}
	function getTotalToday() {
		$page = $_SERVER['REQUEST_URI'];
		$where = "page='$page'";
		$sDate = date("Ymd");
		$eDate = date("Ymd",strtotime("+1 day"));
		$where .= " and wDate between $sDate and $eDate";
		return Q::total($this->table, $where);
	}
	function getTotal(){
		$page = $_SERVER['REQUEST_URI'];
		$where = "page='$page'";
		return Q::total($this->table, $where);
	}
	function __toString() {
		return '';
	}
}


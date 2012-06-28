<?
class MadWhere {
	protected $where = array();
	protected $sess;

	function __construct() {
		$this->sess = new MadSession(__class__);
	}
	function isEmpty() {
		return empty( $this->where );
	}
	function add( $condition, $glue='and' ) {
		$glues = array('and','or');
		if ( in_array($glue, $glues) ) {
			$glue = $glue;
		} else {
			$glue = $glues[0];
		}
		$this->where[][$glue] = $condition;
	}
	function ckGet($key) {
		if ( $value = ckGet($key) ) {
			$this->add("$key = '$value'");
		}
	}
	function get() {
		$where = '';
		if ( !empty( $this->where ) ) {
			$where = ' where';
			$flag = 0;
			foreach ( $this->where as $conditions ) {
				foreach ( $conditions as $glue => $condition ) {
					if ( $flag == 0 ) {
						$where .= " $condition";
						$flag = 1;
					} else {
						$where .= " $glue $condition";
					}
				}
			}
		}
		return $where;
	}
	function getLastWhere() {
		return $this->sess->lastWhere;
	}
	function __toString() {
		return $this->get();
	}
	function test() {
		printR($this->searchables);
	}
	function __destruct() {
		$this->sess->lastWhere = $this->get();
	}
}

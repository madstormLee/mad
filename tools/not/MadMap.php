<?
class MadMap {
	protected $no;
	protected $relNo;
	protected $table;

	function __construct() {
		$this->table = get_class($this);
	}
	function setNo( $no ) {
		$this->no = $no;
		return $this;
	}
	function setRelNo( $relNo ) {
		$this->relNo = $relNo;
		return $this;
	}
	function getNo( $relNo ) {
		if ( is_array( $relNo ) ) {
			$relNo = implode( ',', $relNo );
		}
		$rv = array();
		$query = "select no from $this->table where relNo in ($relNo)";
		$q = new Q($query);
		return $q->getColumn('no');
	}
	function getRelNo( $no ) {
		if ( is_array( $no ) ) {
			$no = implode( ',', $no );
		}
		$rv = array();
		$query = "select relNo from $this->table where no in ($no)";
		$q = new Q($query);
		return $q->getColumn('relNo');
	}
	function insertNo( $noes ) {
		if ( empty( $this->relNo ) ) {
			return false;
		}
		if ( ! is_array( $noes ) ) {
			$noes = array( $noes );
		}
		$rv = 0;
		$set = new MadSet;
		$set->relNo = $this->relNo;
		foreach( $noes as $no ) {
			if ( empty( $no ) ) {
				continue;
			}
			$set->no = $no;
			$query = "insert into $this->table $set";
			$q = new Q($query);
			$rv += $q->rows();
		}
		return $rv;
	}
	function insertRelNo( $relNoes ) {
		if ( empty( $this->no ) ) {
			return false;
		}
		if ( ! is_array( $relNoes ) ) {
			$relNoes = array( $relNoes );
		}
		$rv = 0;
		$set = new MadSet;
		$set->no = $this->no;
		foreach( $relNoes as $relNo ) {
			if ( empty( $relNo ) ) {
				continue;
			}
			$set->relNo = $relNo;
			$query = "insert into $this->table $set";
			$q = new Q($query);
			$rv += $q->rows();
		}
		return $rv;
	}
	function delete( $no, $relNo ) {
		$query = "delete from $this->table where no = $no and relNo = $relNo";
		$q = new Q($query);
		return $q->rows();
	}
	function deleteNo( $no ) {
		if ( ! is_array( $no ) ) {
			$no = array( $no );
		}
		$noes = implode( ',', $no );
		$q = new Q("delete from $this->table where no in ($noes)");
		return $q->rows();
	}
	function deleteRelNo( $relNo ) {
		if ( ! is_array( $relNo ) ) {
			$relNo = array( $relNo );
		}
		$relNoes = implode( ',', $relNo );
		$q = new Q("delete from $this->table where relNo in ($relNoes)");
		return $q->rows();
	}
}

<?
class MadSearch {
	protected $where = array();
	protected $table;
	protected $sess;
	protected $searchables = array();

	function __construct() {
		$this->sess = new MadSession(__class__);
	}
	function addSearch( $field, $search='' ) {
		$this->searchables[$field] = $search;
	}
	function makeSearch() {
		foreach( $this->searchables as $field => $search ) {
			if ( strpos($search, '-') ) {
				$between = explode('-',$search);
				$start = ckGet( $between[0] );
				$end = ckGet( $between[1] );
				if ( $start && $end ) {
					$this->addWhere("$field between '$start' and '$end'");
				}
			} else {
				if ( $searchText = ckGet($search) ) {
					$this->addWhere("$field like '%$searchText%'");
				}
			}
		}
	}
	function addSearchIni( $iniFile ) {
		$searchables = new MadIniManager( $iniFile );
		foreach( $searchables as $value ) {
			$this->searchables[] = $value;
		}
	}
	function setIni( $iniFile = '' ) {
		$this->searchables = new MadIniManager($iniFile );
	}
	function addWhere( $condition, $glue='and' ) {
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
		$this->makeSearch();
		$where = '';
		if ( !empty( $this->where ) ) {
			$where = ' where';
			$i = 0; foreach ( $this->where as $conditions ) {
				foreach ( $conditions as $glue => $condition ) {
					if ( $i == 0 ) {
						$where .= " $condition"; $i = 1;
					} else {
						$where .= " $glue $condition";
					}
				}
			}
		}
		$this->sess->lastWhere = $where;
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
}

<?
class MadTree implements IteratorAggregate {
	private $source;
	private $tree;

	public function __construct( $tuple, $relNo = 0, $depth = 0 ) {
		$this->tree = $this->makeTree($tuple, $relNo, $depth);
	}
	private function makeTree( &$tuple, $relNo=0, $depth=0 ) {
		$rv = array();
		++$depth;
		$orderNo = 1; foreach ( $tuple as $key => $row ) {
			if ( $row['relNo'] == $relNo ) {
				unset( $tuple[$key] );
				$no = $row['no'];
				$row['depth'] = $depth;
				$row['orderNo'] = $orderNo;

				$subTree = $this->makeTree($tuple,$no, $depth);
				$row['subs'] = count( $subTree );

				$this->source[$no] = $row;
				$row['subTree'] = $subTree;
				$rv[$no] = $row;
				++$orderNo;
			}
		}
		return $rv;
	}
	public function getSub( $relNo ) {
		$tuple = $this->source; //source를 직접 건드려선 안된다.
		return $this->makeTree($tuple, $relNo);
	}
	function get( $key ) {
		if ( isset( $this->source[$key] ) ) {
			return $this->source[$key];
		}
		return false;
	}
	function getRelNo( $no ) {
		if ( isset($this->source[$no]) ) {
			return $this->source[$no]['relNo'];
		} 
		return 0;
	}
	function getSubs( $no ) {
		return $this->source[$no]['subs'];
	}
	function hasSub( $no ) {
		if ( $this->source[$no]['subs'] > 0 ) {
			return true;
		}
		return false;
	}
	function getDepth( $no ) {
		return $this->source[$no]['depth'];
	}
	function getLine( $no ) {
		$rv[] = $no;
		while( $no = $this->getRelNo($no) ) {
			$rv[] = $no;
		}
		$rv = array_reverse($rv);
		return $rv;
	}
	function getTree() {
		return $this->tree;
	}
	function getSource() {
		return $this->source;
	}
	function getIterator() {
		return new ArrayIterator($this->source);
	}
	function __set( $key, $value ) {
		$this->source[$key] = $value;
	}
	function __get( $key ) {
		if ( isset( $this->source[$key] ) ) {
			return $this->source[$key];
		}
	}
	function test() {
		printR($this->tree);
	}
}

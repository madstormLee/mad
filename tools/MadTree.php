<?
class MadTree implements IteratorAggregate {
	private $data;
	private $tree;

	public function __construct( $data, $relNo = 0, $depth = 0 ) {
		$this->data = new MadData;
		$this->tree = $this->makeTree($data, $relNo, $depth);
	}
	private function makeTree( &$data, $relNo=0, $depth=0 ) {
		$rv = new MadData;
		++$depth;
		$orderNo = 1;
		foreach ( $data as $key => $row ) {
			$row = new MadData( $row );
			if ( $row->relNo == $relNo ) {
				unset( $data[$key] );
				$row->depth = $depth;
				$row->orderNo = $orderNo;
				$row->subTree = $this->makeTree($data, $row->no, $depth);
				$row->subs = $row->subTree->count();

				$this->data->{$row->no} = $row;
				$rv->{$row->no} = $row;

				++$orderNo;
			}
		}
		return $rv;
	}
	public function getSub( $relNo ) {
		$tuple = $this->data; //source를 직접 건드려선 안된다.
		return $this->makeTree($tuple, $relNo);
	}
	function get( $key ) {
		if ( isset( $this->data[$key] ) ) {
			return $this->data[$key];
		}
		return false;
	}
	function getRelNo( $no ) {
		if ( isset($this->data[$no]) ) {
			return $this->data[$no]['relNo'];
		} 
		return 0;
	}
	function getSubs( $no ) {
		if ( $this->data->$no->subs > 0 ) {
			return $this->data->$no->subTree; 
		}
		return array();
	}
	function hasSub( $no ) {
		if ( $this->data[$no]['subs'] > 0 ) {
			return true;
		}
		return false;
	}
	function getDepth( $no ) {
		return $this->data[$no]['depth'];
	}
	function getLineColumn( $no, $column ) {
		$rv = array();
		if ( ! $this->data->$no ) {
			return $rv;
		}
		$rv[] = $this->data->$no->$column;
		while( $no = $this->data->$no->relNo ) {
			$rv[] = $this->data->$no->$column;
		}
		$rv = array_reverse($rv);
		return $rv;
	}
	function getLine( $no ) {
		$rv = array();
		$rv[] = $this->data->$no;
		while( $no = $this->data->$no->relNo ) {
			$rv[] = $this->data->$no;
		}
		$rv = array_reverse($rv);
		return $rv;
	}
	function getTree() {
		return $this->tree;
	}
	function getSource() {
		return $this->data;
	}
	function getIterator() {
		return $this->tree;
	}
	function __set( $key, $value ) {
		$this->data[$key] = $value;
	}
	function __get( $key ) {
		if ( isset( $this->data[$key] ) ) {
			return $this->data[$key];
		}
	}
	function test() {
		printR($this->tree);
	}
}

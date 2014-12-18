<?
class MadTree implements IteratorAggregate {
	private $data;
	private $tree;
	private $parentid = 'parentid';

	public function __construct( $data, $relNo = 0, $depth = 0 ) {
		$this->data = $data->getData();
		$this->tree = $this->makeTree2($data, $relNo, $depth);
	}
	private function makeTree2( $data ) {
		$data = new MadData( $data );
		$i=0; foreach ( $data as $key => &$row ) {
			if( $row->$parentid == 0 ) {
				continue;
			}
			if( empty( $data->{$row->$parentid}->subs ) ) {
				$data->{$row->$parentid}->subs = array();
			}
			$data->{$row->$parentid}->subs[$row->id] = $row;
			unset( $data->$key );
		}
		return $data;
	}
	private function makeTree( $data, $relNo=0, $depth=0 ) {
		$rv = new MadData;
		++$depth;
		$order = 1;
		foreach ( $data as $key => &$row ) {
			unset( $data->$key );
			if ( $row->parentid != $relNo ) {
				continue;
			}
			$row->depth = $depth;
			$row->order = $order;
			if( $subs = $this->makeTree( $data, $row->id, $depth ) ) {
				$row->subs = $subs;
				$row->subcount = count( $row->subs );
			} else {
				$row->subcount = 0;
			}


			$this->data->{$row->id} = $row;
			$rv->{$row->id} = $row;

			++$order;
		}
		if ( $rv->isEmpty() ) {
			return false;
		}
		return $rv;
	}
	public function getSub( $relNo ) {
		$tuple = $this->data;
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
		(new MadDebug)->printR($this->tree);
	}
}

<?
class MadDlTree {
	protected $data;
	protected $tree;
	protected $callback;
	protected $dt = "<dt>{name}</dt>";
	protected $dd = "<dd>{subTree}</dd>";

	function __construct( $data ) {
		$this->data = $data;
	}
	function setDt( $dt ) {
		$this->dt = $dt;
		return $this;
	}
	function setDd( $dd ) {
		$this->dd = $dd;
		return $this;
	}
	function fromMadTree( $tree, $depth = 0 ) {
		$rv = "<dl>";
		foreach( $tree as $row ) {
			$keys = array();
			$values = array();
			foreach( $row as $key => $value ) {
				if ( $key == 'subTree' ) {
					$value = $this->fromMadTree( $value );
				}
				$keys[] = '{' . $key . '}';
				$values[] = $value;
			}
			$rv .= str_replace( $keys, $values, $this->dt );

			if ( $row->subs > 0 ) {
				$rv .= str_replace( $keys, $values, $this->dd );
			}
		}
		$rv .= "</dl>";
		return $rv;
	}
	function fromValue( $data, $depth = 0 ) {
		++$depth;
		$rv = "<dl class='temp$depth'>\n";
		foreach( $data as $key => $value ){
			$rv .= "<dt>$key</dt>\n";
			if ( ! isArray( $value ) ) {
				$rv .= "<dd style='display: none'>$value</dd>\n";
			} else {
				$rv .= "<dd style='display: none'>" . $this->fromValue( $value, $depth ) ."</dd>\n";
			}
		}
		$rv .= "</dl>\n";
		return $rv;
	}
	function __toString() {
		if ( $this->data instanceof MadTree ) {
			$this->callback = 'fromMadTree';
		} else {
			$this->callback = 'fromValue';
		}
		$this->tree = $this->{$this->callback}( $this->data );
		return $this->tree;
	}
}

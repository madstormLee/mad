<?
class MadTag_Dl {
	private $data;
	function __construct( $data = '' ) {
		$this->setData( $data );
	}
	function setData( $data ) {
		if ( ! empty( $data ) ) {
			$this->data = $data;
		}
		return $this;
	}
	public function getTree( $data = '' , $depth = 0 ) {
		if ( empty( $data ) ) {
			$data = $this->data;
		}
		++$depth;
		$rv = "<dl class='depth$depth'>\n";
		foreach( $data as $key => $value ){
			$rv .= "<dt>$key</dt>\n";
			if ( ! isArray( $value ) ) {
				$rv .= "<dd>$value</dd>\n";
			} else {
				$rv .= "<dd>" . $this->getTree( $value, $depth ) ."</dd>\n";
			}
		}
		$rv .= "</dl>\n";
		return $rv;
	}
}

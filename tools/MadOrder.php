<?
class MadOrder {
	private $data = array();

	function __construct() {
	}
	function set( $order ) {
		$this->data = array();
		$this->add( $order );
	}
	function add( $order ) {
		$this->data[] = $order;
	}
	function get() {
		$rv = '';
		if ( ! empty( $this->data ) ) {
			$rv = 'order by ' . implode( ',', $this->data );
		}
		return $rv;
	}
	function __toString() {
		return $this->get();
	}
}

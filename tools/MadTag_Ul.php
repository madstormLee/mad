<?
// this class is temporal implementation.
class MadTag_Ul extends Mad {
	function __construct( $data = '' ) {
		if ( is_array( $data ) ) {
			$this->setData( $data );
		}
	}
	function setData( $data ) {
		// need something check
		$this->data = $data;
	}
	function get() {
		if ( empty( $this->data ) ) {
			return '';
		}
		$rv = '<ul>';
		foreach( $this->data as $name => $href ) {
			$rv .= "<li><a href='$href'>$name</a></li>";
		}
		$rv .= '</ul>';
		return $rv;
	}
	function __toString() {
		return $this->get();
	}
}

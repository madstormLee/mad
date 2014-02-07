<?
class MadPwdNavi implements IteratorAggregate {
	private $data = array();

	function __construct() {
	}
	function add( $href, $label ) {
		$this->data[] = array(
			'href' => $href,
			'label' => $label,
		);
		return $this;
	}
	function unshift( $href, $label ) {
		$row = array(
			'href' => $href,
			'label' => $label,
		);
		array_unshift( $this->data, $row );
		return $this;
	}
	function getParents() {
		$cnt = count( $this->data ) -1;
		if ( $cnt > 0 ) {
			return new MadData( array_slice( $this->data, 0, $cnt ) );
		}
		return new MadData( array() );
	}
	function getCurrent() {
		return new MadData( end( $this->data ) );
	}
	function getIterator() {
		return new ArrayIterator( $this->data );
	}
	function __toString() {
		if ( empty( $this->data ) ) {
			return '';
		}
		foreach( $this->getParents() as $row ) {
			$href = $row['href'];
			$label = $row['label'];
			$rv[] = "<a href='$href'>$label</a>";
		}
		$rv[] = "<span class='current'>" . $this->getCurrent()->label . '</span>';

		return implode( ' &gt; ', $rv );
	}
}

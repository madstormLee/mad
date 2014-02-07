<?
class ModelList implements IteratorAggregate {
	private $data = array();
	function __construct( $dir ) {
		$dir = new MadFile( $dir );
		$dir->filter('^\.');

		foreach( $dir as $row ) {
			$this->data[] = new Model( $row->getFile() );
		}
	}
	function getIterator() {
		return new ArrayIterator( $this->data );
	}
}

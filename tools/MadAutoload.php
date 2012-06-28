<?
class MadAutoload implements IteratorAggregate {
	private static $instance;
	private $data = array();

	function __construct( $data = '' ) {
		if ( ! empty( $data ) ) {
			if ( ! is_array( $data ) ) {
				$data = (array) $data;
			}
			$this->data->append( $data );
		}
	}
	static function getInstance() {
		if ( ! self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}
	function setData( $data = array() ) {
		$this->data->append( $data );
		return $this;
	}
	function getData() {
		return $this->data;
	}
	function addDir( $dirName ) {
		if ( ( ! in_array( $dirName, $this->data ) )
				&&	is_dir( $dirName ) ) {
			$this->data[] = $dirName;
		}
		return $this;
	}
	function getIterator() {
		return new ArrayIterator( $this->data );
	}
	function test() {
		printR( $this->data );
	}
}

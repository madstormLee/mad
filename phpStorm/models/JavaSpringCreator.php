<?
class JavaSpringCreator implements IteratorAggregate {
	private $data;
	private $created = null;
	private $prototypes = null;

	private $targetDir = '';

	function __construct( $dir ) {
		$this->data = new MadData;
		$this->created = new MadData;
		$this->targetDir = $dir;
	}
	function getIterator() {
		return $this->created;
	}
	function getCreated() {
		return $this->created;
	}
	function create() {
		if ( ! is_dir( $this->targetDir ) ) {
			mkdir( $this->targetDir, 0777, true );
		}
		return dirCopy( 'proto/javaSpring/skeleton/', $this->targetDir );
	}
	function remove() {
		return `rm -rf {$this->targetDir}`;
	}
	function setConfig(  MadJson $config ) {
		$this->config = $config;
		return $this;
	}
	function __set( $key, $value ) {
		$this->data->$key = $value;
	}
	function __get( $key ) {
		return $this->data->$key;
	}
}

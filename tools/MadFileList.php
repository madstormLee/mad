<?
class MadFileList implements IteratorAggregate {
	protected $dir; 
	protected $modelName;
	protected $ext = '';
	protected $data = array(); 

	function __construct( $dir = '' ) {
		$this->modelName = substr( get_class($this), 0, -4 );
		if ( ! empty( $dir ) ) {
			$this->setDir( $dir );
		}
	}
	function setExt( $ext ) {
		$this->ext = $ext;
		return $this;
	}
	function getExt() {
		return $this->ext;
	}
	function setModelName( $modelName ) {
		$this->modelName = $modelName;
	}
	function getModelName() {
		return $this->modelName;
	}
	function getIterator() {
		if ( $this->isEmpty() ) {
			$this->setData();
		}
		return new ArrayIterator( $this->data );
	}
	function setDir( $dir = '' ) {
		$this->dir = $dir;
		return $this;
	}
	function getDir() {
		return $this->dir;
	}
	function isEmpty() {
		return empty( $this->data );
	}
	function getData() {
		return $this->data;
	}
	function getCount() {
		if ( ! is_dir( $this->dir )  ) {
			return 0;
		}
		$this->setData();
		return count( $this->data );
	}
	function setData() {
		$data = array();
		$modelName = $this->modelName;

		$dir = new MadDir( $this->dir );
		if ( ! empty( $this->ext ) ) {
			$dir->setType( "/\.$this->ext$/i" );
		}
		foreach( $dir as $file ) {
			$model = new $modelName( $file );
			$data[$file] = $model;
		}
		$this->data = $data;
		return $this;
	}
	function __get( $key ) {
		return ckKey( $key, $this->data );
	}
	function test() {
		printR( $this->data );
	}
}

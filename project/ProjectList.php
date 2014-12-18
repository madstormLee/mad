<?
class ProjectList implements IteratorAggregate {
	protected $dir = 'projects';
	protected $data = array();

	function __construct( $dir = 'projects' ) {
		$this->dir = $dir;
	}
	function getIterator() {
		$this->init();
		return new ArrayIterator( $this->data );
	}
	function init() {
		if ( ! empty( $this->data ) ) {
			return $this;
		}
		$dirs = new MadFile( $this->dir );
		if ( ! $dirs->isDir() ) {
			return $this;
		}
		$dirs->filter('^\.');

		foreach( $dirs as $dir ) {
			$file = $dir->getFile() . '/.pxProject';
			if ( ! is_file( $file ) ) {
				$json = $this->getDefault( $file );
			} else {
				$json = new MadJson( $file );
			}
			$json->dir = $dir->getFile();
			$this->data[] = $json;
		}
		return $this;
	}
	private function getDefault( $file ) {
		$json = new MadJson( $file );
		$basename = baseName( dirName( $file ) );
		$json->id = $basename;
		$json->name = $basename;
		$json->label = $basename;
		$json->description = $basename;
		return $json;
	}
}

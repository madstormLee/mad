<?
// maybe this extends FileList or DirScan?
class ComponentList implements IteratorAggregate {
	protected $data = array();

	function __construct( MadData $data = null ) {
		$project = Project::getSession();
		$dir = $project->root . $project->configs->dirs->components;
		if ( ! is_dir( $dir ) ) {
			mkdir( $dir, 0777, true );
		}
		$this->setData( $dir );
	}
	function setData( $targetDir ) {
		$dirs = scandir( $targetDir );
		foreach( $dirs as $dir ) {
			if ( 0 === strpos( $dir, '.' ) ) {
				continue;
			}
			$file = $targetDir . $dir . '/component.json';
			if ( is_file( $file ) ) {
				$key = baseName( $dir );
				$this->data[$key] = new MadJson( $file );
			}
		}
		return $this;
	}
	function getIterator() {
		return new ArrayIterator( $this->data );
	}
	function isEmpty() {
		return empty( $this->data );
	}
}

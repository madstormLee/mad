<?
class SchemeList implements IteratorAggregate {
	private $schemeDir = 'schemes'; // convention.

	function __construct( $schemeDir = 'schemes' ) {
		$this->schemeDir = $schemeDir;
		$this->data = new MadData;
		$this->setData();
	}
	function setData() {
		$list = scandir( $this->schemeDir );
		$schemes = $this->db->getTables();

		foreach( $list as $file ) {
			if ( 0 === strpos( $file, '.' ) ) continue;
			$file = new SplFileInfo($file);
			$name = current( explode('.', $file->getBasename() ) ); 

			$this->data->$name = array(
					'filename' => $this->schemeDir . '/' . $file->getFilename(),
					'basename' => $file->getBasename(),
					'installed' => $schemes->in( $name ) ? 'installed' : false,
					'total' => $schemes->in( $name ) ? $this->db->total( $name ) : 0,
					);
		}
		return $this;
	}
	function getIterator() {
		return $this->data;
	}
}

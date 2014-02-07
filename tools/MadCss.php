<?
class MadCss {
	private static $instance;

	protected $data = array();

	protected $mediaTypes = array( 'screen', 'tty', 'tv', 'projection', 'handheld', 'print', 'braille', 'aural', 'all');
	protected $modes = array( 'link', 'import' );
	protected $mode = 'link';

	private function __construct() {
	}
	public static function getInstance(){
		if(! isset(self::$instance) ){
			self::$instance = new self;
		}
		return self::$instance;
	}
	public function setMode( $mode = 'link' ) {
		if( ! in_array( $mode, $modes ) ) {
			throw new Exception( "No $mode mode" );
		}
		$this->mode = $mode;
	}
	public function add( $fileName, $mediaType='all' ) {
		$mediaType = ( in_array($mediaType, $this->mediaTypes) ) ? $mediaType : 'all';
		$fileName = str_replace('.css','',$fileName);

		if ( ! isset( $this->data[$mediaType] ) ) {
			$this->data[$mediaType][] = $fileName;
		} else if ( ! in_array( $fileName, $this->data[$mediaType] ) ) {
			$this->data[$mediaType][] = $fileName;
		}
		return $this;
	}
	public function addExists( $fileName ) {
		if ( is_file ( preg_replace('!\~/!i', PROJECT_ROOT, $fileName ) ) ) {
			return $this->add( $fileName );
		}
		return $this;
	}
	public function set($fileName, $mediaType='all') {
		$this->add($fileName, $mediaType );
	}
	public function remove($pattern) {
		foreach ( $this->data as $mediaType => $fileNames ) {
			foreach( $fileNames as $key => $fileName ) {
				if ( strpos($fileName, $pattern) !== false) {
					unset( $this->data[$mediaType][$key] );
				}
			}
		}
	}
	public function setMedia($mediaType) {
		if ( ! in_array($mediaTypes, $mediaType) ) {
			throw new Exception( "No $mediaType type" );
		}
		$this->mediaType = $mediaType;
	}
	public function clear() {
		$this->data = array();
		return $this;
	}
	public function test() {
		(new MadDebug)->printR($this->data);
	}
	private function getLink() {
		$rv = array();
		foreach ( $this->data as $mediaType => $importFiles ) {
			foreach ( $importFiles as $importFileName ) {
				$rv []= "<link rel='stylesheet' href='$importFileName.css' type='text/css' media='$mediaType' />";
			}
		}
		return implode("\n", $rv);
	}
	private function getImport () {
		$rv = '';
		foreach ( $this->data as $mediaType => $importFiles ) {
			$rv .= "<style type='text/css' media='$mediaType'>\n";
			foreach ( $importFiles as $importFileName ) {
				$rv .= "@import '$importFileName.css';\n";
			}
			$rv .= "</style>\n";
		}
		$projectRoot = MadGlobal::getInstance()->projectRoot;
		$rv = preg_replace('!(@import\s*["\'])~/!i', "$1$projectRoot", $rv);
		return $rv;
	}
	function __toString(){
		$target = 'get' . ucFirst( $this->mode );
		return $this->$target();
	}
}

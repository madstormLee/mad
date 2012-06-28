<?
class MadCss extends MadSingletonData {
	private static $instance;
	private $mode = 'link';
	private $modes = array(
			0 => 'link',
			1 => 'import',
			);
	private $mediaTypes = array( 'screen', 'tty', 'tv', 'projection', 'handheld', 'print', 'braille', 'aural', 'all');

	public static function getInstance(){
		if(! isset(self::$instance) ){
			self::$instance = new self;
		}
		return self::$instance;
	}
	public function add($fileName, $mediaType='all') {
		$mediaType = ( in_array($mediaType, $this->mediaTypes) ) ? $mediaType : 'all';
		$fileName = str_replace('.css','',$fileName);

		if ( ! isset( $this->data[$mediaType] ) ) {
			$this->data[$mediaType][] = $fileName;
		} else if ( ! in_array( $fileName, $this->data[$mediaType] ) ) {
			$this->data[$mediaType][] = $fileName;
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
		if ( in_array($mediaTypes, $mediaType) ) {
			$this->mediaType = $mediaType;
		}
	}
	public function clear() {
		$this->data = array();
		return $this;
	}
	public function test() {
		printR($this->data);
	}
	private function getLink() {
		$rv = array();
		foreach ( $this->data as $mediaType => $importFiles ) {
			foreach ( $importFiles as $importFileName ) {
				$rv []= "<link rel='stylesheet' href='$importFileName.css' type='text/css' media='$mediaType' />\n";
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

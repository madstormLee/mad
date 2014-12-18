<?
class MadCss {
	private static $instance;

	private $router;
	protected $data = array();

	protected $mediaTypes = array( 'screen', 'tty', 'tv', 'projection', 'handheld', 'print', 'braille', 'aural', 'all');
	protected $modes = array( 'link', 'import' );
	protected $mode = 'link';

	public static function getInstance(){
		if(! isset(self::$instance) ){
			self::$instance = new self;
		}
		return self::$instance;
	}
	private function __construct() {
		$this->router = MadRouter::getInstance();
	}
	public function setMode( $mode = 'link' ) {
		if( ! in_array( $mode, $modes ) ) {
			throw new Exception( "No $mode mode" );
		}
		$this->mode = $mode;
	}
	public function add( $file, $media='all' ) {
		$media = ( in_array($media, $this->mediaTypes) ) ? $media : 'all';

		if ( ! isset( $this->data[$media] ) ) {
			$this->data[$media][] = $file;
		} else if ( ! in_array( $file, $this->data[$media] ) ) {
			$this->data[$media][] = $file;
		}
		return $this;
	}
	public function addExists( $file ) {
		if ( is_file( $this->router->pathAdjust($file) ) ) {
			return $this->add( $file );
		}
		return $this;
	}
	public function set($file, $media='all') {
		$this->add($file, $media );
		return $this;
	}
	public function remove($pattern) {
		foreach ( $this->data as $media => $files ) {
			foreach( $files as $key => $file ) {
				if ( strpos($file, $pattern) !== false) {
					unset( $this->data[$media][$key] );
				}
			}
		}
	}
	public function setMedia($media) {
		if ( ! in_array($this->mediaTypes, $media) ) {
			throw new Exception( "No $media type" );
		}
		$this->media = $media;
	}
	public function clear() {
		$this->data = array();
		return $this;
	}
	private function getLink() {
		$rv = array();
		foreach ( $this->data as $media => $files ) {
			foreach ( $files as $file ) {
				$rv []= "<link rel='stylesheet' href='$file' type='text/css' media='$media' />";
			}
		}
		return implode("\n", $rv);
	}
	private function getImport () {
		$rv = '';
		foreach ( $this->data as $media => $files ) {
			$rv .= "<style type='text/css' media='$media'>\n";
			foreach ( $files as $file ) {
				$rv .= "@import '$file';\n";
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

<?
class MadConventions {
	private static $instance = null;
	private $data;

	private $loaders;

	private function __construct() {
		$this->loaders = new MadData( array(
			'ini' => 'MadIni',
			'json' => 'MadJson',
			'xml' => 'MadXml',
		) );
		$this->data = array(
			'config' => 'configs/config.ini',
			'convention' => MAD . 'configs/conventions.ini',
		);
	}
	public function getInstance() {
		if ( ! self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}
	function load( $target ) {
		$file = new MadFile( $this->$target );
		if ( ! $file->exists() ) {
			return false;
		}
		$ext = $file->getExtension();
		if ( $loader = $this->loaders->$ext ) {
			$loader = new $loader;
			$loader->load( $file );
			return $loader;
		}
	}
}

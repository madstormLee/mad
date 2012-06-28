<?
class MadConventions {
	private static $instance = null;
	private $data;

	private $loaders = array(
			'ini' => 'MadIni',
			'json' => 'MadJson',
			'xml' => 'MadXml',
			);

	private function __construct() {
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
		if ( $file = $this->$target ) {
			$ext = getExtension( $file );
			if ( $loader = ckKey( $ext, $this->loaders ) ) {
				$loader = new $loader;
				$loader->load( $file );
				return $loader;
			}
		}
		return false;
	}
	function __get( $key ) {
		return ckKey( $key, $this->data );
	}
	function __set( $key, $value ) {
		$this->data[$key] = $value;
	}
}

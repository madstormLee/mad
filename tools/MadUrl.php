<?
class MadUrl {
	private static $instance;
	private $data;

	private function __construct() {
		$this->data = new MadData;
		$root = dirname($_SERVER['SCRIPT_NAME']);
		$url = ckKey('REQUEST_URI', $_SERVER);
		// remove if index.php exists
		if ( 0 === strpos( $url,$_SERVER['SCRIPT_NAME'] ) ) {
			$url = substr( $url, strlen( $_SERVER['SCRIPT_NAME'] ) );
		} else {
			$url = substr($url, strlen($root));
		}
		$this->url = parse_url( $url );
		$data = array_filter( explode('/', $this->url['path']) );
		$this->request = implode('/', $data );

		$i = 0;
		foreach( $data as $value ) {
			$name = 'arg' . $i;
			$this->data->$name = $value;
			++$i;
		}
	}
	public static function getInstance() {
		if ( ! self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}
	function getRequest() {
		return $this->request;
	}
	function __set( $key, $value ) {
		$this->data->$key = $value;
	}
	function __get( $key ) {
		return $this->data->$key;
	}
	function test() {
		printR( $this->data );
	}
}

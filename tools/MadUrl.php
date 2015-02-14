<?
class MadUrl {
	private static $instance;
	private $data;

	private function __construct() {
		$this->data = new MadData;
		$root = dirname($_SERVER['SCRIPT_NAME']);
		$server = MadParams::create('_SERVER');
		$url = $server->REQUEST_URI;
		// remove if index.php exists
		if ( 0 === strpos( $url,$server->SCRIPT_NAME ) ) {
			$url = substr( $url, strlen( $server->SCRIPT_NAME ) );
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
	function getBack() {
		$url = parse_url( $_SERVER['HTTP_REFERER'] );
		return $url['path'] . '?' . $url['query'];
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
		(new MadDebug)->printR( $this->data );
	}
}

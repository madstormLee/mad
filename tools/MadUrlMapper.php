<?
class MadUrlMapper {
	private static $instance;
	private $data;

	public static function getInstance( $sitemap = null ) {
		if ( ! self::$instance ) {
			self::$instance = new self( $sitemap );
		}
		return self::$instance;
	}
	private function __construct( $sitemap = null ) {
		$this->data = new MadData;
		$server = MadParam::create('_SERVER');
		$this->base = dirname($_SERVER['SCRIPT_NAME']);
		$url = $server->REQUEST_URI;
		// remove if index.php exists
		if ( 0 === strpos( $url,$server->SCRIPT_NAME ) {
			$url = substr( $url, strlen( $server->SCRIPT_NAME ) );
		} else {
			$url = substr( $url, strlen($this->base) );
		}
		$this->url = parse_url( $url );
		$args = array_filter( explode('/', $this->url['path']) );
		$this->request = '/' . implode('/', $args );

		$i = 0;
		foreach( $args as $value ) {
			$name = 'arg' . $i;
			$this->data->$name = $value;
			++$i;
		}

		$map = $sitemap->getUrlMap();
		$mapped = $map->{$this->request};

		if ( $mapped ) {
			$this->controller = $mapped['controller'];
			$this->action = $mapped['action'];
		} else {
			$this->controller = ucFirst( $this->arg0 );
			$this->action  = $this->arg1;
		}
		if ( ! $this->controller ) {
			$this->controller = 'Index';
		}
		if ( ! $this->action ) {
			$this->action = 'index';
		}
	}
	function getRequest() {
		return $this->request;
	}
	function getController() {
		return $this->controller;
	}
	function getAction() {
		return $this->action;
	}
	function getArguments() {
		return $this->args;
	}
	function __set( $key, $value ) {
		$this->data->$key = $value;
	}
	function __get( $key ) {
		return $this->data->$key;
	}
}

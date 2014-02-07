<?
class ProjectLog {
	private static $instance;

	protected $data = null;

	protected function __construct() {
		$name = get_class( $this );
		$session = MadParams::create('session');
		if ( ! $session->$name ) {
			$_SESSION[$name] = new MadData;
		}
		$this->data = &$_SESSION[$name];
	}
	public static function getInstance() {
		if( ! isset(self::$instance) ){
			self::$instance = new self;
		}
		return self::$instance;
	}
	function open( Project $project ) {
		$this->data->setData( $project );
		return $this;
	}
	function isOpen() {
		return ! $this->data->isEmpty();
	}
	function test() {
		printR( $this->data );
	}
	function __isset( $key ) {
		return isset( $this->data->$key );
	}
	function __get( $key ) {
		return $this->data->$key;
	}
	function __set( $key, $value ) {
		$this->data->$key = $value;
	}
}

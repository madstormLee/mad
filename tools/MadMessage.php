<?
class MadMessage {
	private static $instance = null;
	private $data;
	const UNDEFINED_ERROR = 0;

	private function __construct() {
		$this->data = new MadData;
		$this->setFromJson( MAD . 'messages.json' );
	}
	public function getInstance() {
		if ( ! self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}
	private function setFromJson( $jsonFile ) {
		if ( is_file( $jsonFile ) ) {
			$this->data->set( json_decode( file_get_contents( $jsonFile ) , 1 ) );
		}
		return $this;
	}
	function getMessage( $key ) {
		if ( ! $this->data->$key ) {
			$key = 'undefined';
		}
		return $this->data->$key;
	}
	function __get( $key ) {
		return $this->getMessage( $key );
	}
	function test() {
		$this->data->test();
	}
}

<?
class MadGetText {
	private static $instance = null;
	private $data = array();

	private function __construct() {
	}
	public static function getInstance() {
		if ( ! self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}
	// temporal test loader.
	function addJson( $jsonFile ) {
		$this->data = toJis( json_decode( file_get_contents( $jsonFile ), true ) );
		return $this;
	}
	function addData( $data ) {
		$this->data = array_merge( $data, $this->data  );
		return $this;
	}
	// like a getText...
	function setLocale( $locale ) {
	}
	// why need wrapper?
	function setDomain( $domain ) {
		textdomain( $domain );
		return $this;
	}
	function __get( $key ) {
		if ( isset( $this->data[$key] ) ) {
			return $this->data[$key];
		}
		return $key;
	}
}

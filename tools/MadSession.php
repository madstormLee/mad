<?
class MadSession extends MadAbstractData {
	private static $instance;
	protected $data;

	protected function __construct() {
		$this->data = &$_SESSION;
		self::start();
	}
	public static function getInstance() {
		self::$instance || self::$instance = new self;
		return self::$instance;
	}
	public static function start() {
		/*
		header('P3P: CP="ALL CURa ADMa DEVa TAIa OUR BUS IND PHY ONL UNI PUR FIN COM NAV INT DEM CNT STA POL HEA PRE LOC OTC"');
		$server = PxParams::create('_SERVER');
		session_set_cookie_params (0,"/", $server->SERVER_NAME );
		if ( isset( $_POST["PHPSESSID"] ) ) {
			session_id( trim( $_POST["PHPSESSID"] ) );
		} elseif ( isset( $_GET["PHPSESSID"] ) ) {
			session_id( trim( $_GET["PHPSESSID"] ) );
		}
		*/
		return session_start();
	}
	public static function destroy() {
		return session_destroy();
	}
	function setData( $data = null ) {
		$_SESSION = $data;
		return $this;
	}
	function __call( $method, $args ) {
		$function = 'session_' . $method;
		if ( ! function_exists( $function ) ) {
			throw new Exception( "there is no $method method in " . get_class( $this ) . ' class.');
		}
		return call_user_func_array( $function, $args );
	}
}

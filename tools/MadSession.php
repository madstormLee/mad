<?
class MadSession extends MadAbstractData {
	private static $instance;
	protected $data;

	protected function __construct() {
		self::start();
		$this->data = &$_SESSION;
	}
	public static function getInstance() {
		self::$instance || self::$instance = new self;
		return self::$instance;
	}
	public static function start( $id = '' ) {
		if ( ! empty($id) ) {
			session_id( $id );
		}
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

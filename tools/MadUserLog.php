<?
class MadUserLog {
	private static $instance;

	protected $data = null;
	protected $levels = null;

	protected function __construct() {
		$name = get_class( $this );
		$session = MadParams::create('_SESSION');
		if ( ! $session->$name ) {
			$session->$name = new MadData;
		}
		$this->data = &$session->$name;
		$this->initLevels();
	}
	public static function getInstance() {
		if( ! isset(self::$instance) ){
			self::$instance = new self;
		}
		return self::$instance;
	}
	protected function initLevels() {
		$name = get_class( $this );
		$file = "configs/$name/levels.json";
		if ( is_file( $file ) ) {
			$this->levels = new MadJson( $file );
		} else {
			$this->levels = new MadData( array(
						'root' => 0,
						'admin' => 1,
						'localAdmin' => 5,
						'member' => 200,
						'user' => 255,
						'default' => 300,
						) );
		}
	}
	public function getLevels() {
		return $this->levels;
	}
	public function getLevel() {
		if ( ! isset( $this->level ) ) {
			if ( ! $this->levels->default ) {
				return 300;
			}
			return $this->levels->default;
		}
		return $this->level;
	}
	public function inLevel( $condition ) {
		if ( empty( $condition ) ) {
			return true;
		}
		list($sLevel, $eLevel) = explode('-', $condition);
		$userLevel = $this->getLevel();
		return ( $userLevel >= $sLevel && $userLevel <= $eLevel );
	}
	public function logout() {
		$this->data->clear();
		return $this;
	}
	public function isLogin() {
		return $this->getLevel() <= $this->levels->member;
	}
	public final function isRoot() {
		return $this->getLevel() === 0;
	}
	function __isset( $key ) {
		return isset( $this->data->$key );
	}
	function __get( $key ) {
		return $this->data->$key;
	}
	function __set( $key, $value ) {
		throw new Exception( 'No Access' );
	}
	public function __call( $method, $args ) {
		if ( 0 === strpos( $method , 'is' ) ) {
			if ( $this->isRoot() ) {
				return true;
			}
			$target = lcFirst( substr( $method, 2 ) );
			if ( ! $level = $this->levels->$target ) {
				return false;
			}
			return $this->level === $level;
		}
		throw new Exception("there is no $method method in " . __class__);
	}
}

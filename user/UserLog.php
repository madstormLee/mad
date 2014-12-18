<?
class UserLog extends MadUserLog {
	private static $instance;

	private function __construct() {
	}
	public static function getInstance() {
		return self::$instance ? self::$instance : self::$instance = new self;
	}
	public function getUser() {
		return $this->data;
	}
	public function isLogin() {
		return $this->getLevel() <= $this->levels->member;
	}
	public function getId() {
		return $this->userid;
	}
	public function login( User $user ) {
		if ( $user->level !==0 && ! $user->level ) {
			$user->level = $this->levels->member;
		}
		$this->data->setData( $user );
		return $this;
	}
	public function __call( $method, $args ) {
		if ( 0 === strpos( $method , 'is' ) ) {
			if ( $this->isRoot() ) {
				return true;
			}
			$method = new MadString( $method );
			$target = $method->sub(2)->lcFirst();
			if ( ! $level = $this->levels->$target ) {
				return false;
			}

			return $this->level === $level;
		}
		throw new Exception("there is no $method method in " . __class__);
	}
	// from AdminUserLog
	static function log( $user ) {
		$targets = array(
			'id' => 'relid',
			'userid' => 'userid',
			'level' => 'level',
		);
		$data = new MadData;
		foreach( $user as $key => $value ) {
			if ( isset( $targets[$key] ) ) {
				$target = $targets[$key];
				$data->$target = $value;
			}
		}

		$model = new self;
		$model->setData( $data );
		return $model->insert();
	}
	static function logout() {
		$db = MadDb::create();
		$log = LogUser::getInstance();
		$id = $db->max( 'admin_user_log', 'id', "relid=$log->id" );
		$query = "update admin_user_log set logout_time = now() where id=$id";
		return $db->exec( $query );
	}
}


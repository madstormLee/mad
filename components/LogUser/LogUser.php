<?
class LogUser extends MadUserLog {
	private static $instance;

	public static function getInstance(){
		if(! isset(self::$instance) ){
			self::$instance = new self;
		}
		return self::$instance;
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
}

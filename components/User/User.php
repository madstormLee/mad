<?
class User extends MadUserLog {
	private static $instance;
	protected $data = null;

	public static function getInstance() {
		if(! isset(self::$instance) ){
			self::$instance = new self;
		}
		return self::$instance;
	}
	public function login( MadData $data ) {
		$users = new MadJson('configs/users.json');
		if ( ! $info = $users->{$data->id} ) {
			throw new Exception('No User!');
		}
		if ( $info->pw != sha1( $data->pw ) ) {
			throw new Exception('Wrong password!');
		}
		$_SESSION['User'] = $info;
		$this->data = $_SESSION['User'];
		return $this;
	}
	function __isset( $key ) {
		return isset( $this->data->$key );
	}
	function __get( $key ) {
		return $this->data->$key;
	}
}

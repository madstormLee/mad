<?
class User extends MadModel {
	protected $data = array();
	protected $levels = null;
	protected $level = 1000;

	function __construct( $id='' ) {
		$this->initLevels();
		$this->fetch( $id );
	}
	public static function getSession() {
		if ( isset( $_SESSION['user'] ) ) {
			return $_SESSION['user'];
		}
		return new self;
	}
	protected function initLevels() {
		$this->levels = new MadJson( "user/levels.json" );
		if ( ! $this->levels->isFile() ) {
			$this->levels->setData( array(
				'root' => 0,
				'admin' => 1,
				'localAdmin' => 5,
				'member' => 200,
				'user' => 255,
				'default' => 300,
			) );
		}
	}
	function getNameLevel( $name = '' ) {
		return $this->getLevels()->$name;
	}
	function getLevelName( $level ) {
		return $this->getLevels()->find($level);
	}
	function getScheme() {
		return "
			create table User (
				id integer unsigned auto_increment primary key,
				userId char(20) not null unique,
				userPassword char(42) not null,
				userLevel tinyint unsigned not null default 255,
				name char(20) not null,
				email char(255) not null,
				uDate timestamp default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
				wDate date
			);
		";
	}
	function getIndex() {
		return glob( "$this->dir/*$this->extension");
	}
	public function getLevels() {
		return $this->levels;
	}
	function isLogin() {
		return $this->getLevel() <= $this->getLevel('member');
	}
	public final function isRoot() {
		return $this->getLevel() === 0;
	}
	function isAdmin() {
		return $this->isLevel( 1 );
	}
	function isLevel( $level=1000 ) {
		if ( is_string( $level ) ) {
			$level = $this->getNameLevel( $level );
		}
		return $this->getLevel() === $level;
	}
	public function inLevel( $condition ) {
		if ( empty( $condition ) ) {
			return true;
		}
		list($sLevel, $eLevel) = explode('-', $condition);
		$userLevel = $this->getLevel();
		return ( $userLevel >= $sLevel && $userLevel <= $eLevel );
	}
	function hasAuth( $level = 0 ) {
		return $this->getLevel() <= $level ;
	}
	function fetch( $id='' ) {
		if ( empty( $id ) ) {
			return $this;
		}
		$json = new MadJson( "user/data/$id.json" );
		$this->data = $json->getData();
		$this->setLevel( $json->level );
		return $this;
	}
	function fetchLogin( $id, $pw ) {
		$this->fetch( $id );
		if ( $this->password != sha1( $pw ) ) {
			throw new Exception('Wrong id/password.');
		}
		if ( ! $info = $users->{$data->id} ) {
			throw new Exception('No User!');
		}
		if ( $info->pw != sha1( $data->pw ) ) {
			throw new Exception('Wrong password!');
		}
		return $this;
	}
	function login() {
		$_SESSION['user'] = $this;
		return $this;
	}
	function logout() {
		unset( $_SESSION['user'] );
		return true;
	}
	function setLevel( $level = 1000 ) {
		$this->level = $level;
		return $this;
	}
	public function getLevel() {
		if ( isset( $this->level ) ) {
			return $this->level;
		}
		if ( ! isset($this->levels->default) ) {
			return 300;
		}
		return $this->levels->default;
	}
	function getDefaultLevel() {
		if ( ! isset($this->levels->default) ) {
			$this->levels->default = 300;
		}
		return $this->levels->default;
	}
	function __set( $key, $value ) {
		throw new Exception( 'No Access to ' . $key );
	}
	public function __call( $method, $args ) {
		if ( 0 !== strpos( $method , 'is' ) ) {
			throw new Exception("there is no $method method in " . __class__);
		}
		if ( $this->isRoot() ) {
			return true;
		}
		$target = lcFirst( substr( $method, 2 ) );
		if ( ! $level = $this->levels->$target ) {
			return false;
		}
		return $this->level === $level;
	}
	/******************** not using ********************/
	function checkIp() {
		$ipCheck = new IpCheck;
		if (! $ipCheck->isAdmin("")) {
			throw new Exception( '허가되지 않은 접근 아이피입니다.' );
		}
		return true;
	}
}

<?
class User extends MadModel {
	protected $data = array();
	protected $levels = null;

	function __construct( $id='' ) {
		$this->userLevel = 1000;
		parent::__construct( $id );
	}
	public static function session() {
		if ( isset( $_SESSION['user'] ) ) {
			return $_SESSION['user'];
		}
		return new self;
	}
	function install() {
		$query = new MadScheme( $this );
		$db = $this->getDb();
		return $db->exec( $query );
	}
	function save() {
		$this->userPw = sha1($this->userPw);
		if ( empty($this->id) ) {
			$this->wDate = date('Y-m-d H:i:s');
		}
		$this->uDate = date('Y-m-d H:i:s');
		return parent::save();
	}
	function insert() {
		$this->wDate = date('Y-m-d H:i:s');
		$this->uDate = date('Y-m-d H:i:s');

		$query = new MadQuery( get_class($this) );
		$query->insert( array_filter($this->data) );

		$db = $this->getDb();

		$stmt = $db->prepare( $query );
		$result = $stmt->execute( $query->data() );
		return $db->lastInsertId();
	}
	function getNameLevel( $name = '' ) {
		return $this->getLevels()->$name;
	}
	function getLevelName( $level ) {
		return $this->getLevels()->find($level);
	}
	private $findLevel = '<=100';
	function setFindLevel( $findLevel = '<=100' ) {
		$this->findLevel = $findLevel;
	}
	function getIndex() {
		$index = new MadIndex( $this );
		$query = $index->getQuery();
		$my = self::session();

		if ( $my->id ) {
			$query->where( "( userLevel > $my->userLevel or id = $my->id )" );
		} else {
			$query->where( "userLevel > $my->userLevel" );
		}

		$query->order("uDate desc");
		return $index;
	}
	public function getLevels() {
		return $this->getSetting('userLevel')->options;
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
	function getDb() {
		return MadDb::create();
	}
	function fetch( $id='' ) {
		if ( empty( $id ) ) {
			return $this;
		}
		$query = "select * from User where id=:id";
		$stmt = $this->getDb()->prepare( $query );
		$stmt->execute( array( ':id' => $id ) )->fetch(PDO::FETCH_ASSOC);
		return $this;
	}
	function fetchUserId( $userId ) {
		$query = "select * from User where userId=:userId";
		$stmt = $this->getDb()->prepare( $query );
		if( ! $stmt->execute( array( 'userId' => $userId ) ) ) {
			throw new Exception('No user : ' . $userId);
		}
		$this->data = $stmt->fetch(PDO::FETCH_ASSOC);
		return $this;
	}
	function fetchLogin( $userId, $userPw ) {
		$this->fetchUserId( $userId );
		if( $this->userPw != sha1( $userPw ) ) {
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

<?
class MadDbConn {
	protected static $default = null;
	protected static $connections = array();

	protected $connectInfo = null;
	protected $pdo = null;
	protected $debug = false;

	public static function setDefault( PDO $connect = null ) {
		if ( is_null( $connect ) ) {
			$info = MadConfig::getInstance()->databases->default;
			self::createPdo( $info );
		}
		self::$default = $connect;
	}
	public static function createPdo( $info ) {
		if ( isset( self::$connections[$info->name] ) ) {
			$pdo = self::$connections[$info->name];
		} else {
			$dsn = "$info->server:dbname=$info->db;host=$info->host;port=$info->port";
			$pdo = new PDO( $dsn, $info->id, $info->pw );
			$pdo->exec("set schema '$info->schema'");
			self::addConnections( $info->name, $pdo );
		}
		return $pdo;
	}
	function getInsertId( $key = '' ) {
		return $this->getConnect()->lastInsertId( $key );
	}
	function getConnect() {
		if ( $info = $this->getConnectInfo() ) {
			$this->pdo = self::createPdo( $info );
		} else {
			$this->pdo = $this->getDefault();
		}
		return $this->pdo;
	}
	function setConnect( PDO $pdo ) {
		$this->pdo = $pdo;
		return $this;
	}
	function getDefault() {
		if ( ! self::$default ) {
			self::setDefault( $this->getConnectFromConvention() );
		}
		return self::$default;
	}
	function getConnectFromConvention() {
		if ( ! $info = $this->getConnectInfo() ) {
			throw new Exception("DBConnection info does not exist.");
		}
		return self::createPdo( $info );
	}
	function getConnectInfo() {
		if ( ! $this->connectInfo ) {
			$this->connectInfo = $this->getConnectInfoFromGlobals();
		}
		return $this->connectInfo;
	}
	function getConnectInfoFromGlobals() {
		if ( $databases = MadGlobals::getInstance()->databases ) {
			return $databases->default;
		}
		return false;
	}
	function getDebug() {
		return $this->debug;
	}
}

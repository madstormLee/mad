<?
// 아무래도 front에서 초기 설정을 해 주어야 겠다.
class MadDbConnect {
	public static $iniFile;
	public static $pdo = null;

	static function setDbConnect( $connectInfo ) {
	}
	static function setIni( $iniFile ) {
	}
	static function getPdo() {
		// 일단 config에서 지정하도록 했지만, self로 간다.
		// setter를 만든다.
		if ( ! is_null( self::$pdo ) ) {
			return self::$pdo;
		}
		if ( ! is_file( self::$iniFile ) ) {
			throw new Exception("DBConnectFile does not exist.");
		}
		$ini = new MadIni( self::$iniFile );
		$info = $ini->database;
		return self::create( $info );
	}
	static function getDsn( $info ) {
		return "$info->server:dbname=$info->db;host=$info->host;port=$info->port";
	}
	static function create( $info ) {
		$dsn = self::getDsn( $info );
		return self::$pdo = new PDO($dsn, $info->id, $info->pw);
	}
}

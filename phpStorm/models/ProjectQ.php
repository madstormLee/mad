<?
// 프로젝트용 Q를 따로 사용한다.
class ProjectQ extends MadQ {
	function __construct($query=''){
		$this->dbh = self::getPDO();
		if ( !empty( $query ) ) {
			$this->query($query);
		}
	}
	static function getPDO() {
		$phpStorm = PhpStorm::getInstance();
		// 사실상 connection을 열어주는 script가 필요하지만, 시간상 직접 만들어 주고, 나중에 처리한다.
		$g = MadGlobal::getInstance();
		$file = $phpStorm->getFile('dbConnect');
		try {
			if ( ! is_file( $file) ) {
				throw new Exception("DBConnectFile does not exist.");
			}
			$ini = new MadIni( $file );
			$info = $ini->database;
			$dsn = "$info->server:dbname=$info->db;host=$info->host;port=$info->port";
			return new PDO($dsn, $info->id, $info->pw);
		} catch (PDOException $e) {
			echo 'Connection failed: ' . $e->getMessage();
		} catch (Exception $e ) {
			echo 'Connection failed: ' . $e->getMessage();
			die;
		}
	}
}

<?
class MadInstaller {
	private $schemesDir;
	private $force = false;
	private $dbName = '';

	function __construct($schemesDir=MADSCHEMES) {
		$this->className = __class__;
		$this->schemesDir = $schemesDir;
		if ( isset( $_POST[$this->className] ) ) {
			$action = $_POST[$this->className];
			$this->$action();
		}
	}
	private function makeConn() {
		extract($post = sqlin($_POST));
		$conn = @mysql_connect($host,$id,$pw);
		$db = @mysql_select_db($db);
		if ( ! $conn or ! $db ) {
			alert('접속 정보가 올바르지 않습니다.', 'back','replace');
		}
		$set = new MadSet($post);
		$set->remove($this->className);
		$this->ini = new MadIniManager( MADINI . 'conn.ini' );
		$result = $this->ini->save($set);
		if ( ! $result ) {
			alert('저장에 문제가 생겼습니다.', 'back', 'replace');
		}
		move('/mad/ProgramManager', 'replace');
	}
	function formFromTable($table) {
		$q = new Q("explain $table");
		if ( $q->rows() < 1 ) {
			return false;
		}
		$tableArr = explode('_', $table);
		$tableId = array_shift($tableArr);
		$tail = implode('_',$tableArr);
		$form = new MadForm;

		$tuple = $q->toArray();
		$rv = "<form id='$tableId' class='$tail' method='post' action='?'>\n\t<ul>\n\t<input type='hidden' name='mode' value='ins' />\n";
		$unit = array();
		foreach( $tuple as $row ) {
			extract ($row);
			if ( $Extra == 'auto_increment'
				or $Default == 'CURRENT_TIMESTAMP'
				or $Field == 'wDate') {
				continue;
			}
			$rv .= "\t\t<li><label for='$Field'>$Field</label>";
			if ( strpos($Type, 'char') !== false ) {
				$rv .= $form->text($Field);
			} else if ( strpos($Type, 'date') !== false ) {
				$rv .= "\t\t".$form->date($Field);
			} else if ( strpos($Type, 'text') !== false ) {
				$rv	.= "\t\t".$form->textarea($Field);
			}
			$rv .= "</li>\n";
		}
		$rv .= "<li class='buttons'>\n<input class='btnSubmit' type='submit' value='확인' />\n<input class='btnReset' type='reset' value='취소' />\n</li>\n</ul>";
		$rv .= "</form>\n";
		return $rv;
	}
	function install($target) {
		if ( $this->force == false && is_table($target) ) {
			return false;
		}

		$tableName = $target;
		if ( strpos($target, '.' ) ) {
			$tableName = array_pop( explode( '.', $target ) );
		}
		if ( strpos($tableName, '_') ) {
			$tableName = array_shift( explode( '_', $tableName) );
		}
		$schemeFile = $this->schemesDir . '/' . $tableName . '.sql';
		if (! is_file($schemeFile)) {
			return false;
		}
		$query = preg_replace("/$tableName/",$target,file_get_contents($schemeFile),1);

		$q = new Q( $query );
		return $q->result;
	}
	function uninstall() {
	}
	function tables($name = '') {
		$rv = array();
		$result = mysql_query("show tables like '%$name%'");
		while ( $row = mysql_fetch_array($result) ){
			$rv[]=$row[0];
		}
		return $rv;
	}
	function setDatabase( $dbName ) {
		$this->dbName = $dbName;
		return $this;
	}
	function createDatabase( $dbName ) {
		$query = "create database $dbName";
		$q = new Q($query);
		return $this;
	}
	function dropTable($table){
		if ( strpos($table,'%') !== false ) {
			$query = "show tables like '$table'";
			$q = new Q($query);
			$table = implode(',',$q->col());
		}
		new Q("drop table $table");
	}
}

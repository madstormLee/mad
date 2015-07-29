<?
error_reporting(E_ALL);
ini_set('display_errors', 'on');
class LiteController extends MadController {
	function init() {
		parent::init();


		$config_filename = "$this->component/phpliteadmin.config.php";
		if (is_readable($config_filename)) {
			include_once $config_filename;
		}

		define("PROJECT", "phpLiteAdmin");
		define("VERSION", "1.9.5");
		define("PAGE", basename(__FILE__));
		define("FORCETYPE", false); //force the extension that will be used (set to false in almost all circumstances except debugging)
		define("SYSTEMPASSWORD", $password); // Makes things easier.
		define('PROJECT_URL','http://phpliteadmin.googlecode.com');
		define('PROJECT_BUGTRACKER_LINK','<a href="http://code.google.com/p/phpliteadmin/issues/list" target="_blank">http://code.google.com/p/phpliteadmin/issues/list</a>');
		define("COOKIENAME", preg_replace('/[^a-zA-Z0-9_]/', '_', $cookie_name) . '_' . VERSION );


		if($language != 'en') {
			if(is_file('languages/lang_'.$language.'.php')) {
				include('languages/lang_'.$language.'.php');
			} elseif(is_file('lang_'.$language.'.php')) {
				include('lang_'.$language.'.php');
			}
		}

		include "$this->component/functions.php";
		include "$this->component/lang.php";
		include "$this->component/Resources.php";
		include "$this->component/MicroTimer.php";
		include "$this->component/Authorization.php";
		include "$this->component/Database.php";


		if(ini_get("register_globals") == "on" || ini_get("register_globals")=="1") {
			throw new Exception( $lang['bad_php_directive'] );
		}
		// don't mess with this - required for the login session
		ini_set('session.cookie_httponly', '1');

		$this->db = new Database($currentDB);
		$this->db->registerUserFunction($custom_functions);

		$auth = $this->auth;

		if (isset($_POST['login']) && isset($_POST['password'])) {
			$auth->attemptGrant($_POST['password'], isset($_POST['remember']));
		}

		$model = $this->model;

		if ($auth->isAuthorized()) {
			$this->config->addMessage( $lang['not_dir'] );
			$model->checkSession();
		}
	}
	function authAction() {
		$this->layout->setFile( "$this->component/authLayout.html" );
		$this->view->auth = $this->auth;
	}
	function logoutAction() {
		$auth->revoke();
	}
	function indexAction() {
		if(isset($_SESSION['currentDB']) && in_array($_SESSION['currentDB'], $databases)) {
			$currentDB = $_SESSION['currentDB'];
		}

		if(!isset($_SESSION['currentDB']) && count($databases)>0) {
			$_SESSION['currentDB'] = reset($databases);
		}

		if(sizeof($databases)>0) {
			$currentDB = $_SESSION['currentDB'];
		} else {
			$this->view->setFile("$this->component/errors_ext.html");
			return $this->view;
		}
	}
	function structureAction() {
		$query = "SELECT sqlite_version() AS sqlite_version";
		$queryVersion = $db->select($query);
		$realVersion = $queryVersion['sqlite_version'];

		if(isset($_GET['sort']) && ($_GET['sort']=='type' || $_GET['sort']=='name'))
			$_SESSION['sortTables'] = $_GET['sort'];
		if(isset($_GET['order']) && ($_GET['order']=='ASC' || $_GET['order']=='DESC'))
			$_SESSION['orderTables'] = $_GET['order'];

		$query = "SELECT type, name FROM sqlite_master WHERE (type='table' OR type='view') AND name!='' AND name NOT LIKE 'sqlite_%'";
		$queryAdd = "";
		if(isset($_SESSION['sortTables']))
			$queryAdd .= " ORDER BY ".$db->quote_id($_SESSION['sortTables']);
		else
			$queryAdd .= " ORDER BY \"name\"";
		if(isset($_SESSION['orderTables']))
			$queryAdd .= " ".$_SESSION['orderTables'];
		$query .= $queryAdd;
		$result = $db->selectArray($query);


		$totalRecords = 0;
		$skippedTables = false;
		for($i=0; $i<sizeof($result); $i++) {
			$records = $db->numRows($result[$i]['name'], (!isset($_GET['forceCount'])));
			if($records == '?') {
				$skippedTables = true;
				$records = "<a href='?forceCount=1'>?</a>";
			} else {
				$totalRecords += $records;
			}
		}

		$orderTag = "ASC";
		$sortArrow = '&darr;';
		if( isset($_SESSION['sortTables']) &&
			$_SESSION['sortTables']=="name" &&
			$_SESSION['orderTables']=="ASC") {
				$orderTag = "DESC";
				$sortArrow = '&uarr;';
			}
	}
	function sqlAction() {
		$post = $this->params;
		if ( ! $post->delimiter ) {
			$post->delimiter = ";";
		}

		$queries = explode_sql($post->delimiter, $post->queryStr);

		$data = array();
		foreach( $queries as $query ) {
			if( trim($query) == "" ) {
				continue;
			}
			$row = new MadData;
			$row->query = $query;

			$queryTimer = new MicroTimer();
			if(preg_match('/^\s*(?:select|pragma|explain)\s/i', $query)===1) {
				$row->isSelect = true;
				$result = $db->selectArray($query, "assoc");
			} else {
				$row->isSelect = false;
				$result = $db->query($query);
			}
			$queryTimer->stop();

			if($result===false) {
				$row->rows = $lang['err'].": ".$db->getError();
			} else {
				if($row->isSelect) {
					$row->rows = printf($lang['show_rows'], sizeof($result));
				} else {
					$row->rows = $db->getAffectedRows().' '.$lang['rows_aff'];
				}
				$row->rows .= printf($lang['query_time'], $queryTimer);
			}

			if( $row->isSelect && sizeof($result) > 0 ) {
				$row->headers = array_keys($result[0]);
				$row->values = $result;
			}
		}
	}
	function vaccumAction() {
		if($post->vacuum) {
			$query = "VACUUM";
			$db->query($query);
		}
	}
	function importAction() {
		$query = "SELECT name FROM sqlite_master WHERE type='table' OR type='view' ORDER BY name";
		$result = $db->selectArray($query);
	}
	function importConfirmAction() {
		$db = new Database($_SESSION['currentDB']);
		$db->registerUserFunction($custom_functions);
		if($_POST['import_type']=="sql") {
			$data = file_get_contents($_FILES["file"]["tmp_name"]);
			$importSuccess = $db->import_sql($data);
		} else {
			$field_terminate = $_POST['import_csv_fieldsterminated'];
			$field_enclosed = $_POST['import_csv_fieldsenclosed'];
			$field_escaped = $_POST['import_csv_fieldsescaped'];
			$null = $_POST['import_csv_replacenull'];
			$fields_in_first_row = isset($_POST['import_csv_fieldnames']);
			$importSuccess = $db->import_csv($_FILES["file"]["tmp_name"], $_POST['single_table'], $field_terminate, $field_enclosed, $field_escaped, $null, $fields_in_first_row);
		}
	}
	function renameAction() {
	}
	function databaseRenameAction() {
		$post = $this->params;

		$oldpath_parts = pathinfo($post->oldname);
		$newpath_parts = pathinfo($post->newname);
		// only rename?
		$newpath = $oldpath_parts['dirname'].DIRECTORY_SEPARATOR.basename($_POST['newname']);
		if($newpath != $_POST['newname'] && $subdirectories) {
			// it seems that the file should not only be renamed but additionally moved.
			// we need to make sure it stays within $directory...
			$new_realpath = realpath($newpath_parts['dirname']).DIRECTORY_SEPARATOR;
			$directory_realpath = realpath($directory).DIRECTORY_SEPARATOR;
			if(strpos($new_realpath, $directory_realpath)===0) {
				// its okay, the new directory is within $directory
				$newpath = $post->newname;
			}
			else die($lang['err'].': '.$lang['db_moved_outside']);
		}

		$file = new MadFile( $newpath );
		if ($oldpath==$newpath) {
			throw new Exception( $lang['warn_dumbass'] );
		}
		if ( $file->exists() ) {
			throw new Exception( printf($lang['db_exists'], htmlencode($newpath)) );
		}
		$model = $this->model;
		if ( ! $model->isAllowExtension( $file->getExtension() ) ) {
			//todo Refactoring.
			throw new Exception( $lang['extension_not_allowed'] . ':' . implode(', ', array_map('htmlencode', $model->extensions() )) . BR .  $lang['add_allowed_extension'] );
		}

		if( ! $model->isManagedDb( $post->oldname ) ) {
			throw new Exception($lang['err'].': '.$lang['rename_only_managed']);
		}

		$model->rename($post->oldname, $newpath);

		return printf($lang['db_renamed'], htmlencode($post->oldpath))." '".htmlencode($newpath)."'.";
	}
	function deleteAction() {
	}
	function databaseCreateAction() {
		$model = $this->model;

		if($_POST['new_dbname']=='') {
			throw new Exception('no db name');
		}
		$str = preg_replace('@[^\w-.]@','', $_POST['new_dbname']);
		$dbname = $str;
		$dbpath = $str;

		if(checkDbName($dbname)) {
			$tdata = array();	
			$tdata['name'] = $dbname;
			$tdata['path'] = $directory.DIRECTORY_SEPARATOR.$dbpath;
			$td = new Database($tdata);
			$td->query("VACUUM");
		} else {
			if(is_file($dbname) || is_dir($dbname)) $dbexists = true;
			else $extension_not_allowed=true;
		}

		if(isset($tdata)) {
			foreach($model->databases() as $row) {
				if($row['path'] == $tdata['path']) {
					$_SESSION['currentDB'] = $row;
					break;
				}
			}
		}
	}
	function databaseDeleteAction() {
		$model = $this->model;
		$dbpath = $_POST['database_delete'];
		// check whether $dbpath really is a db we manage
		$checkDB = ;
		if( !$model->isManagedDb($dbpath)) {
			throw new Exception ($lang['err'].': '.$lang['delete_only_managed']);
		}
		unlink($dbpath);
		unset($_SESSION['currentDB']);
		unset($databases[$checkDB]);
	}
	function exportAction() {
		$query = "SELECT name FROM sqlite_master WHERE type='table' OR type='view' ORDER BY name";
		$result = $db->selectArray($query);
		for($i=0; $i<sizeof($result); $i++) {
		}
		$file = pathinfo($db->getPath());
		$name = $file['filename'];
	}
	function exportConfirmAction() {
		if($_POST['export_type']=="sql") {
			header('Content-Type: text/sql');
			header('Content-Disposition: attachment; filename="'.$_POST['filename'].'.'.$_POST['export_type'].'";');
			if(isset($_POST['tables'])) {
				$tables = $_POST['tables'];
			} else {
				$tables = array();
				$tables[0] = $_POST['single_table'];
			}
			$drop = isset($_POST['drop']);
			$structure = isset($_POST['structure']);
			$data = isset($_POST['data']);
			$transaction = isset($_POST['transaction']);
			$comments = isset($_POST['comments']);
			$db = new Database($_SESSION['currentDB']);
			echo $db->export_sql($tables, $drop, $structure, $data, $transaction, $comments);
		} else if($_POST['export_type']=="csv") {
			header("Content-type: application/csv");
			header('Content-Disposition: attachment; filename="'.$_POST['filename'].'.'.$_POST['export_type'].'";');
			header("Pragma: no-cache");
			header("Expires: 0");
			if(isset($_POST['tables']))
				$tables = $_POST['tables'];
			else
			{
				$tables = array();
				$tables[0] = $_POST['single_table'];
			}
			$field_terminate = $_POST['export_csv_fieldsterminated'];
			$field_enclosed = $_POST['export_csv_fieldsenclosed'];
			$field_escaped = $_POST['export_csv_fieldsescaped'];
			$null = $_POST['export_csv_replacenull'];
			$crlf = isset($_POST['export_csv_crlf']);
			$fields_in_first_row = isset($_POST['export_csv_fieldnames']);
			$db = new Database($_SESSION['currentDB']);
			echo $db->export_csv($tables, $field_terminate, $field_enclosed, $field_escaped, $null, $crlf, $fields_in_first_row);
		}
		exit();
	}
	function databaseSwitchAction() {
		foreach($databases as $db_id => $database) {
			if($database['path'] == $_POST['database_switch']) {
				$_SESSION["currentDB"] = $database;
				break;
			}
		}
		$currentDB = $_SESSION['currentDB'];
	}
	function switchdbAction() {
		foreach($databases as $db_id => $database) {
			if($database['path'] == $_GET['switchdb']) {
				$_SESSION["currentDB"] = $database;
				break;
			}
		}
		$currentDB = $_SESSION['currentDB'];
	}
	function view_createAction() {
		$query = "CREATE VIEW ".$db->quote($_POST['viewname'])." AS ".$_POST['select'];
		$result = $db->query($query);
		if($result===false)
			$error = true;
		$completed = $lang['view']." '".htmlencode($_POST['viewname'])."' ".$lang['created'].".<br/><span style='font-size:11px;'>".htmlencode($query)."</span>";
		$backlinkParameters = "&amp;action=column_view&amp;table=".urlencode($_POST['viewname'])."&amp;view=1";
	}
	function resourceAction() {
		// without inizializing the session
		$model = new Resources;
		$model->output( $_GET['resource'] );
		exit();
		if (isset($_GET['resource'])) {
			Resources::output();
		}
	}
	function helpAction() {
		include "$this->component/lang.php";
		$help = array (
			$lang['help1'] => sprintf($lang['help1_x'], PROJECT, PROJECT, PROJECT),
			$lang['help2'] => $lang['help2_x'],
			$lang['help3'] => $lang['help3_x'],

			$lang['help4'] => $lang['help4_x'],
			$lang['help5'] => $lang['help5_x'],
			$lang['help6'] => $lang['help6_x'],
			$lang['help7'] => $lang['help7_x'],
			$lang['help8'] => $lang['help8_x'],
			$lang['help9'] => $lang['help9_x']
		);
		$this->view->help = $help;
	}
	function readmeAction() {
		$file = new MadFile("$this->component/README.txt");
		return nl2br($file->getContents());
	}

	function rowEditAction() {
		$pks = explode(":", $_GET['pk']);
		$fields = explode(":", $_POST['fieldArray']);

		$z = 0;

		$query = "PRAGMA table_info(".$db->quote_id($_GET['table']).")";
		$result = $db->selectArray($query);

		if(isset($_POST['new_row']))
			$completed = "";
		else
			$completed = sizeof($pks)." ".$lang['rows']." ".$lang['affected'].".<br/><br/>";

		for($i=0; $i<sizeof($pks); $i++)
		{
			if(isset($_POST['new_row']))
			{
				$query = "INSERT INTO ".$db->quote_id($_GET['table'])." (";
				for($j=0; $j<sizeof($fields); $j++)
				{
					$query .= $db->quote_id($fields[$j]).",";
				}
				$query = substr($query, 0, sizeof($query)-2);
				$query .= ") VALUES (";
				for($j=0; $j<sizeof($fields); $j++)
				{
					$field_index = str_replace(" ","_",$fields[$j]);
					$value = $_POST[$pks[$i].":".$field_index];
					$null = isset($_POST[$pks[$i].":".$field_index."_null"]);
					$type = $result[$j][2];
					$typeAffinity = get_type_affinity($type);
					$function = $_POST["function_".$pks[$i]."_".$field_index];
					if($function!="")
						$query .= $function."(";
					//di - messed around with this logic for null values
					if(($typeAffinity=="TEXT" || $typeAffinity=="NONE") && $null==false)
						$query .= $db->quote($value);
					else if(($typeAffinity=="INTEGER" || $typeAffinity=="REAL" || $typeAffinity=="NUMERIC") && $null==false && $value=="")
						$query .= "NULL";
					else if($null==true)
						$query .= "NULL";
					else
						$query .= $db->quote($value);
					if($function!="")
						$query .= ")";
					$query .= ",";
				}
				$query = substr($query, 0, sizeof($query)-2);
				$query .= ")";
				$result1 = $db->query($query);
				if($result1===false)
					$error = true;
				$z++;
			}
			else
			{
				$query = "UPDATE ".$db->quote_id($_GET['table'])." SET ";
				for($j=0; $j<sizeof($fields); $j++)
				{
					if(!is_numeric($pks[$i])) continue;
					$field_index = str_replace(" ","_",$fields[$j]);
					$function = $_POST["function_".$pks[$i]."_".$field_index];
					$null = isset($_POST[$pks[$i].":".$field_index."_null"]);
					$query .= $db->quote_id($fields[$j])."=";
					if($function!="")
						$query .= $function."(";
					if($null)
						$query .= "NULL";
					else
						$query .= $db->quote($_POST[$pks[$i].":".$field_index]);
					if($function!="")
						$query .= ")";
					$query .= ", ";
				}
				$query = substr($query, 0, sizeof($query)-3);
				$query .= " WHERE ROWID = ".$pks[$i];
				$result1 = $db->query($query);
				if($result1===false)
				{
					$error = true;
				}
			}
			$completed .= "<span style='font-size:11px;'>".htmlencode($query)."</span><br/>";
		}
		if(isset($_POST['new_row']))
			$completed = $z." ".$lang['rows']." ".$lang['inserted'].".<br/><br/>".$completed;
		$backlinkParameters = "&amp;action=row_view&amp;table=".urlencode($_GET['table']);

		$this->view->sqlite = $this->create('Sqlite');
	}
	function primarykey_addAction() {
		$pks = explode(":", $_GET['pk']);
		$query = "ALTER TABLE ".$db->quote_id($_GET['table']).' ADD PRIMARY KEY ('.$db->quote_id($pks[0]);
		for($i=1; $i<sizeof($pks); $i++)
		{
			$query .= ", ".$db->quote_id($pks[$i]);
		}
		$query .= ")";
		$result = $db->query($query);
		if($result===false)
			$error = true;
		$completed = $lang['tbl']." '".htmlencode($_GET['table'])."' ".$lang['altered'].".";
		$backlinkParameters = "&amp;action=column_view&amp;table=".urlencode($_GET['table']);
	}

	function tableCreateAction() {
		$this->view->sqlite = $this->create('Sqlite');

		$query = "SELECT name FROM sqlite_master WHERE type='table' AND name=".$db->quote($_POST['tablename']);
		$results = $db->selectArray($query);

		if($_POST['tablefields']=="" || intval($_POST['tablefields'])<=0)
			throw new Exception( $lang['specify_fields'] );
		else if($_POST['tablename']=="")
			throw new Exception( $lang['specify_tbl'] );
		else if(sizeof($results) > 0)
			throw new Exception( $lang['tbl_exists'] );

		$num = intval($_POST['tablefields']);
		$name = $_POST['tablename'];

		$headings = array($lang['fld'], $lang['type'], $lang['prim_key']);
		if($db->getType() != "SQLiteDatabase") $headings[] = $lang['autoincrement'];
		$headings[] = $lang['not_null'];
		$headings[] = $lang['def_val'];
	}
	function tableCreateConfirmAction() {
		$num = intval($_POST['rows']);
		$name = $_POST['tablename'];
		$primary_keys = array();
		for($i=0; $i<$num; $i++)
		{
			if($_POST[$i.'_field']!="" && isset($_POST[$i.'_primarykey']))
			{
				$primary_keys[] = $_POST[$i.'_field'];
			}
		}
		$query = "CREATE TABLE ".$db->quote($name)." (";
		for($i=0; $i<$num; $i++)
		{
			if($_POST[$i.'_field']!="")
			{
				$query .= $db->quote($_POST[$i.'_field'])." ";
				$query .= $_POST[$i.'_type']." ";
				if(isset($_POST[$i.'_primarykey']))
				{
					if(count($primary_keys)==1)
					{
						$query .= "PRIMARY KEY "; 
						if(isset($_POST[$i.'_autoincrement']) && $db->getType() != "SQLiteDatabase")
							$query .=  "AUTOINCREMENT ";
					}
					$query .= "NOT NULL ";
				}
				if(!isset($_POST[$i.'_primarykey']) && isset($_POST[$i.'_notnull']))
					$query .= "NOT NULL ";
				if($_POST[$i.'_defaultoption']!='defined' && $_POST[$i.'_defaultoption']!='none' && $_POST[$i.'_defaultoption']!='expr')
					$query .= "DEFAULT ".$_POST[$i.'_defaultoption']." ";
				elseif($_POST[$i.'_defaultoption']=='expr')
					$query .= "DEFAULT (".$_POST[$i.'_defaultvalue'].") ";
				elseif(isset($_POST[$i.'_defaultvalue']) && $_POST[$i.'_defaultoption']=='defined')
				{
					$typeAffinity = get_type_affinity($_POST[$i.'_type']);
					if(($typeAffinity=="INTEGER" || $typeAffinity=="REAL" || $typeAffinity=="NUMERIC") && is_numeric($_POST[$i.'_defaultvalue']))
						$query .= "DEFAULT ".$_POST[$i.'_defaultvalue']."  ";
					else
						$query .= "DEFAULT ".$db->quote($_POST[$i.'_defaultvalue'])." ";
				}
				$query = substr($query, 0, sizeof($query)-2);
				$query .= ", ";
			}
		}

		if (count($primary_keys)>1) {
			$compound_key = "";
			foreach ($primary_keys as $primary_key) {
				$compound_key .= ($compound_key=="" ? "" : ", ") . $db->quote($primary_key);
			}
			$query .= "PRIMARY KEY (".$compound_key."), ";
		}
		$query = substr($query, 0, sizeof($query)-3);
		$query .= ")";
		$result = $db->query($query);
		if($result===false)
			$error = true;
		$completed = $lang['tbl']." '".htmlencode($_POST['tablename'])."' ".$lang['created'].".<br/><span style='font-size:11px;'>".htmlencode($query)."</span>";
		$backlinkParameters = "&amp;action=column_view&amp;table=".urlencode($name);
	}
	function tableSqlAction() {
		$isSelect = false;
		$get = $this->params;
		$post = new MadParams('_POST');

		if( ! $post->query ) {
			$table = $db->quote_id($_GET['table']);
			$post->query = "SELECT * FROM $table WHERE 1";
		}
		if( ! $post->delimiter ) {
			$post->delimiter = ";";
		}

		$post->query = $post->queryval;
		$query = explode_sql($post->delimiter, $post->query);

		for($i=0; $i<sizeof($query); $i++) {
			if(str_replace(" ", "", str_replace("\n", "", str_replace("\r", "", $query[$i])))!="") {
				$queryTimer = new MicroTimer();
				if(preg_match('/^\s*(?:select|pragma|explain)\s/i', $query[$i])===1) {
					$isSelect = true;
					$result = $db->selectArray($query[$i], "assoc");
				} else {
					$isSelect = false;
					$result = $db->query($query[$i]);
				}
				$queryTimer->stop();

				echo "<div class='confirm'>";
				echo "<b>";
				if($result!==false) {
					if($isSelect) {
						$affected = sizeof($result);
						echo $lang['showing']." ".$affected." ".$lang['rows'].". ";
					} else {
						$affected = $db->getAffectedRows();
						echo $affected." ".$lang['rows']." ".$lang['affected'].". ";
					}
					printf($lang['query_time'], $queryTimer);
					echo "</b><br/>";
				} else {
					echo $lang['err'].": ".$db->getError().".</b><br/>";
				}
				echo "<span style='font-size:11px;'>".htmlencode($query[$i])."</span>";
				echo "</div><br/>";
				if($isSelect) {
					if(sizeof($result)>0) {
						$headers = array_keys($result[0]);
						echo "<table border='0' cellpadding='2' cellspacing='1' class='viewTable'>";
						echo "<tr>";
						for($j=0; $j<sizeof($headers); $j++) {
							echo "<td class='tdheader'>";
							echo htmlencode($headers[$j]);
							echo "</td>";
						}
						echo "</tr>";
						for($j=0; $j<sizeof($result); $j++) {
							$tdWithClass = "<td class='td".($j%2 ? "1" : "2")."'>";
							echo "<tr>";
							for($z=0; $z<sizeof($headers); $z++) {
								echo $tdWithClass;
								if($result[$j][$headers[$z]]==="")
									echo "&nbsp;";
								elseif($result[$j][$headers[$z]]===NULL)
									echo "<i class='null'>NULL</i>";
								else
									echo subString(htmlencode($result[$j][$headers[$z]]));
								echo "</td>";
							}
							echo "</tr>";
						}
						echo "</table><br/><br/>";
					}
				}
			}
		}
		$query = "PRAGMA table_info(".$db->quote_id($_GET['table']).")";
		$this->view->tableInfo = $db->selectArray($query);
	}
	function tableEmptyAction() {
	}
	function tableEmptyConfirmAction() {
		$post = new MadParams('_POST');

		$query = "DELETE FROM ".$db->quote_id($post->tablename);
		$result = $db->query($query);

		if($result===false) {
			$error = true;
		}

		$query = "VACUUM";
		$result = $db->query($query);

		if($result===false) {
			$error = true;
		}

		$completed = $lang['tbl']." '".htmlencode($_POST['tablename'])."' ".$lang['emptied'].".<br/><span style='font-size:11px;'>".htmlencode($query)."</span>";
		$backlinkParameters = "&amp;action=row_view&amp;table=".urlencode($name);
	}
	function tableDropAction() {
	}
	function tableDropConfirmAction() {
		$query = "DROP TABLE ".$db->quote_id($_POST['tablename']);
		$result=$db->query($query);
		if($result===false)
			$error = true;
		$completed = $lang['tbl']." '".htmlencode($_POST['tablename'])."' ".$lang['dropped'].".";
		$backlinkParameters = "";
	}
	function viewDropAction() {
	}
	function viewDropConfirmAction() {
		$query = "DROP VIEW ".$db->quote_id($_POST['viewname']);
		$result=$db->query($query);
		if($result===false)
			$error = true;
		$completed = $lang['view']." '".htmlencode($_POST['viewname'])."' ".$lang['dropped'].".";
		$backlinkParameters = "";
	}
	function tableExportAction() {
	}
	function tableImportAction() {
	}
	function tableRenameAction() {
	}
	function tableRenameConfirmAction() {
		$query = "ALTER TABLE ".$db->quote_id($_POST['oldname'])." RENAME TO ".$db->quote($_POST['newname']);
		if($db->getVersion()==3)
			$result = $db->query($query, true);
		else
			$result = $db->query($query, false);
		if($result===false)
			$error = true;
		$completed = $lang['tbl']." '".htmlencode($_POST['oldname'])."' ".$lang['renamed']." '".htmlencode($_POST['newname'])."'.<br/><span style='font-size:11px;'>".htmlencode($query)."</span>";
		$backlinkParameters = "&amp;action=row_view&amp;table=".urlencode($_POST['newname']);
	}
	function tableSearchAction() {
		$foundVal = array();
		$fieldArr = array();
		$get = $this->params;

		$query = "PRAGMA table_info(".$db->quote_id($_GET['table']).")";
		$result = $db->selectArray($query);
	}
	function tableSearchDoneAction() {
		$foundVal = array();
		$fieldArr = array();
		$get = $this->params;

		$table = $_GET['table'];
		$query = "PRAGMA table_info(".$db->quote_id($table).")";
		$result = $db->selectArray($query);
		$j = 0;
		$arr = array();

		for($i=0; $i<sizeof($result); $i++) {
			$field = $result[$i][1];
			$field_index = str_replace(" ","_",$field);
			$operator = $_POST[$field_index.":operator"];
			$value = $_POST[$field_index];
			if($value!="" || $operator=="!= ''" || $operator=="= ''") {
				if($operator=="= ''" || $operator=="!= ''") {
					$arr[$j] = $db->quote_id($field)." ".$operator;
				} else{
					if($operator == "LIKE%"){ 
						$operator = "LIKE";
						if(!preg_match('/(^%)|(%$)/', $value)) $value = '%'.$value.'%';
					}
					$fieldArr[] = $field;
					$foundVal[] = $value;
					$arr[$j] = $db->quote_id($field)." ".$operator." ".$db->quote($value);
				}
				$j++;
			}
		}

		$query = "SELECT * FROM ".$db->quote_id($table);
		$whereTo = '';
		if(sizeof($arr)>0) {
			$whereTo .= " WHERE ".$arr[0];
			for($i=1; $i<sizeof($arr); $i++) {
				$whereTo .= " AND ".$arr[$i];
			}
		}
		$query .= $whereTo;
		$queryTimer = new MicroTimer();
		$result = $db->selectArray($query,"assoc");
		$queryTimer->stop();
	}
	function rowViewAction() {
		$table = $_GET['table'];
		$is_view = isset($_GET['view']) ? '&amp;view=1' : '';

		if(!isset($_POST['startRow'])) {
			$_POST['startRow'] = 0;
		}

		if(isset($_POST['numRows'])) {
			$_SESSION['numRows'] = $_POST['numRows'];
		}

		if(!isset($_SESSION['numRows'])) {
			$_SESSION['numRows'] = $rowsNum;
		}

		if(isset($_SESSION['currentTable']) && $_SESSION['currentTable']!=$table) {
			unset($_SESSION['sortRows']);
			unset($_SESSION['orderRows']);	
		}
		if(isset($_POST['viewtype'])) {
			$_SESSION['viewtype'] = $_POST['viewtype'];	
		}

		$rowCount = $db->numRows($table);
		$lastPage = intval($rowCount / $_SESSION['numRows']);
		$remainder = intval($rowCount % $_SESSION['numRows']);

		if($remainder==0) {
			$remainder = $_SESSION['numRows'];
		}

		if(!isset($_GET['sort']))
			$_GET['sort'] = NULL;
		if(!isset($_GET['order']))
			$_GET['order'] = NULL;

		$numRows = $_SESSION['numRows'];
		$startRow = $_POST['startRow'];
		if(isset($_GET['sort'])) {
			$_SESSION['sortRows'] = $_GET['sort'];
			$_SESSION['currentTable'] = $table;
		}
		if(isset($_GET['order'])) {
			$_SESSION['orderRows'] = $_GET['order'];
			$_SESSION['currentTable'] = $table;
		}
		$_SESSION['numRows'] = $numRows;
		$query = "SELECT *, ROWID FROM ".$db->quote_id($table);
		$queryDisp = "SELECT * FROM ".$db->quote_id($table);
		$queryAdd = "";
		if(isset($_SESSION['sortRows']))
			$queryAdd .= " ORDER BY ".$db->quote_id($_SESSION['sortRows']);
		if(isset($_SESSION['orderRows']))
			$queryAdd .= " ".$_SESSION['orderRows'];
		$queryAdd .= " LIMIT ".$startRow.", ".$numRows;
		$query .= $queryAdd;
		$queryDisp .= $queryAdd;
		$queryTimer = new MicroTimer();
		$arr = $db->selectArray($query);
		$queryTimer->stop();

		if(sizeof($arr)>0) {
			$query = "PRAGMA table_info(".$db->quote_id($table).")";
			$result = $db->selectArray($query);
			$rowidColumn = sizeof($result);

			if(!isset($_SESSION['viewtype']) || $_SESSION['viewtype']=="table") {
				$listView = new MadView($this->component.'/rowListView.html');

				if(isset($_SESSION['sortRows'])) {
					$orderTag = ($_SESSION['sortRows']==$result[$i]['name'] && $_SESSION['orderRows']=="ASC") ? "DESC" : "ASC";
				} else {
					$orderTag = "ASC";
				}

			} else {
				$listView = new MadView($this->component.'/rowChartView.html');
				if(!isset($_SESSION[$_GET['table'].'chartlabels'])) {
					// No label-column set. Try to pick a text-column as label-column.
					for($i=0; $i<sizeof($result); $i++) {
						if(get_type_affinity($result[$i]['type'])=='TEXT') {
							$_SESSION[$_GET['table'].'chartlabels'] = $i;
							break;
						}
					}
				}
				if(!isset($_SESSION['chartlabels'])) {
					$_SESSION['chartlabels'] = 0;
				}

				if(!isset($_SESSION[$_GET['table'].'chartvalues'])) {
					$potential_value_column = null;
					for($i=0; $i<sizeof($result); $i++) {
						if($potential_value_column===null && $i != $_SESSION[$_GET['table'].'chartlabels'])
							$potential_value_column = $i;
						$typeAffinity = get_type_affinity($result[$i]['type']);  
						if($typeAffinity=='INTEGER' || $typeAffinity=='REAL' || $typeAffinity=='NUMERIC') {
							$_SESSION[$_GET['table'].'chartvalues'] = $i;
							break;
						}
					}

					if(!isset($_SESSION[$_GET['table'].'chartvalues'])) {
						if($potential_value_column!==null) {
							$_SESSION[$_GET['table'].'chartvalues'] = $potential_value_column;
						} else {
							$_SESSION[$_GET['table'].'chartvalues'] = 0;  
						}
					}
				}

				if(!isset($_SESSION['charttype']))
					$_SESSION['charttype'] = 'bar';

				if(isset($_POST['chartsettings'])) {
					$_SESSION['charttype'] = $_POST['charttype'];	
					$_SESSION[$_GET['table'].'chartlabels'] = $_POST['chartlabels'];
					$_SESSION[$_GET['table'].'chartvalues'] = $_POST['chartvalues'];
				}
			}
		}
	}
	function rowCreateAction() {
		$fieldStr = "";
		$query = "PRAGMA table_info(".$db->quote_id($_GET['table']).")";
		$result = $db->selectArray($query);
		if(isset($_POST['num']))
			$num = $_POST['num'];
		else
			$num = 1;
		for($j=0; $j<$num; $j++) {
			for($i=0; $i<sizeof($result); $i++) {
				$field = $result[$i]['name'];
				$field_html = htmlencode($field);
				if($j==0) {
					$fieldStr .= ":".$field;
				}
				$type = strtolower($result[$i]['type']);
				$typeAffinity = get_type_affinity($type);
			}
		}
		$fieldStr = substr($fieldStr, 1);
		$this->main->sqlite = $this->createModel('Sqlite');
	}
	function rowCreateConfirmAction() {
		$completed = "";
		$num = $_POST['numRows'];
		$fields = explode(":", $_POST['fields']);
		$z = 0;

		$query = "PRAGMA table_info(".$db->quote_id($_GET['table']).")";
		$result = $db->selectArray($query);

		for($i=0; $i<$num; $i++) {
			if(!isset($_POST[$i.":ignore"])) {
				$query_cols = "";
				$query_vals = "";
				$all_default = true;
				for($j=0; $j<sizeof($fields); $j++) {
					$fields[$j] = str_replace(" ","_",$fields[$j]);
					$null = isset($_POST[$i.":".$fields[$j]."_null"]);
					$value = "";
					$all_default = false;

					if(!$null) {
						if(!isset($_POST[$i.":".$fields[$j]]) && $debug) {
							echo "MISSING POST INDEX (".$i.":".$fields[$j].")<br><pre />";
							var_dump($_POST);
							echo "</pre><hr />";
						} 
						$value = $_POST[$i.":".$fields[$j]];
					}
					if($value===$result[$j]['dflt_value']) {
						// if the value is the default value, skip it
						continue;
					}
					$query_cols .= $db->quote_id($fields[$j]).",";

					$type = $result[$j]['type'];
					$typeAffinity = get_type_affinity($type);
					$function = $_POST["function_".$i."_".$fields[$j]];
					if($function!="")
						$query_vals .= $function."(";
					if(($typeAffinity=="TEXT" || $typeAffinity=="NONE") && !$null)
						$query_vals .= $db->quote($value);
					elseif(($typeAffinity=="INTEGER" || $typeAffinity=="REAL"|| $typeAffinity=="NUMERIC") && $value=="")
						$query_vals .= "NULL";
					elseif($null)
						$query_vals .= "NULL";
					else
						$query_vals .= $db->quote($value);
					if($function!="")
						$query_vals .= ")";
					$query_vals .= ",";
				}

				$query = "INSERT INTO ".$db->quote_id($_GET['table']);
				if(!$all_default) {
					$query_cols = substr($query_cols, 0, strlen($query_cols)-1);
					$query_vals = substr($query_vals, 0, strlen($query_vals)-1);

					$query .= " (". $query_cols . ") VALUES (". $query_vals. ")";
				} else {
					$query .= " DEFAULT VALUES";
				}
				$result1 = $db->query($query);
				if($result1===false) {
					$error = true;
				}
				$completed .= "<span style='font-size:11px;'>".htmlencode($query)."</span><br/>";
				$z++;
			}
		}
		$completed = $z." ".$lang['rows']." ".$lang['inserted'].".<br/><br/>".$completed;
		$backlinkParameters = "&amp;action=column_view&amp;table=".urlencode($_GET['table']);
	}
	function rowEditAction() {
		$post = $this->params;

		// this will change with throw exception
		if( empty($post->check) ) {
			$view = new MadView("$this->component/errorView.html");
			$view->get = $get;
			$view->action = 'rowView';
			$view->errorMessage = $lang['no_sel'];
			return $view;
		}

		$pkVal = implode(':', $post->check);
		$this->view->pkVal = $pkVal;

		$query = "PRAGMA table_info(".$db->quote_id($_GET['table']).")";
		$result = $db->selectArray($query);

		$fieldStr = $result[0][1];
		for($j=1; $j<sizeof($result); $j++) {
			$fieldStr .= ":".$result[$j][1];
		}

		for($j=0; $j<sizeof($pks); $j++) {
			if(!is_numeric($pks[$j])) continue;
			$query = "SELECT * FROM ".$db->quote_id($_GET['table'])." WHERE ROWID = ".$pks[$j];
			$result1 = $db->select($query);
			$result[$j]['result1'] = $result1[$j];
		}
		$this->view->result = $result;
	}
	function rowDeleteAction() {
		$get = $this->params;

		if( empty($get->pk) ) {
			$view = new MadView("$this->component/errorView.html");
			$view->get = $get;
			$view->action = 'rowView';
			$view->errorMessage = $lang['no_sel'];
			return $view;
		}

		$pkVal = implode(', ', $get->pk);
		$this->view->pkVal = $pkVal;
	}
	function rowDeleteConfirmAction() {
		$pks = explode(":", $_GET['pk']);
		$query = "DELETE FROM ".$db->quote_id($_GET['table'])." WHERE ROWID = ".$pks[0];
		for($i=1; $i<sizeof($pks); $i++) {
			$query .= " OR ROWID = ".$pks[$i];
		}
		$result = $db->query($query);
		if($result===false) {
			$error = true;
		}
		$completed = sizeof($pks)." ".$lang['rows']." ".$lang['deleted'].".<br/><span style='font-size:11px;'>".htmlencode($query)."</span>";
		$backlinkParameters = "&amp;action=row_view&amp;table=".urlencode($_GET['table']);
	}
	function columnViewAction() {
		$query = "PRAGMA table_info(".$db->quote_id($_GET['table']).")";
		$result = $db->selectArray($query);

		$noPrimaryKey = true;

		for($i=0; $i<sizeof($result); $i++) {
			$colVal = $result[$i][0];
			$fieldVal = $result[$i][1];
			$typeVal = $result[$i]['type'];
			$notnullVal = $result[$i][3];
			$defaultVal = $result[$i][4];
			$primarykeyVal = $result[$i][5];

			if(intval($notnullVal)!=0)
				$notnullVal = $lang['yes'];
			else
				$notnullVal = $lang['no'];

			if(intval($primarykeyVal)!=0) {
				$primarykeyVal = $lang['yes'];
				$noPrimaryKey = false;
			} else {
				$primarykeyVal = $lang['no'];
			}
		}

		$query = "SELECT sql FROM sqlite_master WHERE name=".$db->quote($_GET['table']);
		$master = $db->selectArray($query);

		if(!isset($_GET['view']))
			$type = "table";
		else
			$type = "view";

		$columnNoView = '';
		if( $type == 'table' ) {
			$columnNoView = new MadView('columnNoView.html');

			$query = "PRAGMA index_list(".$db->quote_id($_GET['table']).")";
			$index = $db->selectArray($query);

			$query = "SELECT * FROM sqlite_master WHERE type='trigger' AND tbl_name=".$db->quote($_GET['table'])." ORDER BY name";
			$triggers = $db->selectArray($query);

			$columnNoView->index = $index;
			$columnNoView->triggers = $triggers;
		}
		$this->view->columnNoView = $columnNoView;
	}
	function columnCreateAction() {
		$this->view->sqlite = $this->create('Sqlite');

		if($_POST['tablefields']=="" || intval($_POST['tablefields'])<=0) {
			throw new Exception( $lang['specify_fields'] );
		} else if($_POST['tablename']=="") {
			throw new Exception( $lang['specify_tbl'] );
		}
		$num = intval($_POST['tablefields']);
		$name = $_POST['tablename'];
		$headings = array($lang["fld"], $lang["type"], $lang["prim_key"]);    

		if($db->getType() != "SQLiteDatabase") {
			$headings[] = $lang["autoincrement"];
		}
		$headings[] = $lang["not_null"];
		$headings[] = $lang["def_val"];
	}
	function columnCreateConfirmAction() {
		$num = intval($_POST['rows']);
		for($i=0; $i<$num; $i++) {
			if($_POST[$i.'_field']!="") {
				$query = "ALTER TABLE ".$db->quote_id($_GET['table'])." ADD ".$db->quote($_POST[$i.'_field'])." ";
				$query .= $_POST[$i.'_type']." ";
				if(isset($_POST[$i.'_primarykey']))
					$query .= "PRIMARY KEY ";
				if(isset($_POST[$i.'_notnull']))
					$query .= "NOT NULL ";
				if($_POST[$i.'_defaultoption']!='defined' && $_POST[$i.'_defaultoption']!='none' && $_POST[$i.'_defaultoption']!='expr')
					$query .= "DEFAULT ".$_POST[$i.'_defaultoption']." ";
				elseif($_POST[$i.'_defaultoption']=='expr')
					$query .= "DEFAULT (".$_POST[$i.'_defaultvalue'].") ";
				elseif(isset($_POST[$i.'_defaultvalue']) && $_POST[$i.'_defaultoption']=='defined')
				{
					$typeAffinity = get_type_affinity($_POST[$i.'_type']);
					if(($typeAffinity=="INTEGER" || $typeAffinity=="REAL" || $typeAffinity=="NUMERIC") && is_numeric($_POST[$i.'_defaultvalue']))
						$query .= "DEFAULT ".$_POST[$i.'_defaultvalue']."  ";
					else
						$query .= "DEFAULT ".$db->quote($_POST[$i.'_defaultvalue'])." ";
				}
				if($db->getVersion()==3 &&
					($_POST[$i.'_defaultoption']=='defined' || $_POST[$i.'_defaultoption']=='none' || $_POST[$i.'_defaultoption']=='NULL') &&
					!isset($_POST[$i.'_primarykey'])) {
						$result = $db->query($query, true);
					} else {
						$result = $db->query($query, false);
					}
				if($result===false) {
					$error = true;
				}
			}
		}
		$completed = $lang['tbl']." '".htmlencode($_GET['table'])."' ".$lang['altered'].".";
		$backlinkParameters = "&amp;action=column_view&amp;table=".urlencode($_GET['table']);
	}
	function columnConfirmAction() {
		if(isset($_POST['check']))
			$pks = $_POST['check'];
		elseif(isset($_GET['pk']))
			$pks = array($_GET['pk']);
		else $pks = array();

		if(sizeof($pks)==0) {
			echo "<div class='confirm'>";
			echo $lang['err'].": ".$lang['no_sel'];
			echo "</div>";
			echo "<br/><br/>";
			echo "<a href='./columnView?table=".urlencode($_GET['table'])."'>".$lang['return']."</a>";
		} else {
			$str = $pks[0];
			$pkVal = $pks[0];
			for($i=1; $i<sizeof($pks); $i++) {
				$str .= ", ".$pks[$i];
				$pkVal .= ":".$pks[$i];
			}
		}
	}
	function columnDeleteConfirmAction() {
		$pks = explode(":", $_GET['pk']);
		$query = "ALTER TABLE ".$db->quote_id($_GET['table']).' DROP '.$db->quote_id($pks[0]);
		for($i=1; $i<sizeof($pks); $i++)
		{
			$query .= ", DROP ".$db->quote_id($pks[$i]);
		}
		$result = $db->query($query);
		if($result===false)
			$error = true;
		$completed = $lang['tbl']." '".htmlencode($_GET['table'])."' ".$lang['altered'].".";
		$backlinkParameters = "&amp;action=column_view&amp;table=".urlencode($_GET['table']);
	}
	function columnEditAction() {
		$this->view->sqlite = $this->create('Sqlite');

		if(!isset($_GET['pk']))
			throw new Exception( $lang['specify_col'] );
		else if(!isset($_GET['table']) || $_GET['table']=="")
			throw new Exception( $lang['specify_tbl'] );


		$query = "PRAGMA table_info(".$db->quote_id($_GET['table']).")";
		$result = $db->selectArray($query);

		for($i=0; $i<sizeof($result); $i++) {
			if($result[$i][1]==$_GET['pk']) {
				$colVal = $result[$i][0];
				$fieldVal = $result[$i][1];
				$typeVal = $result[$i]['type'];
				$notnullVal = $result[$i][3];
				$defaultVal = $result[$i][4];
				$primarykeyVal = $result[$i][5];
				break;
			}
		}

		$name = $_GET['table'];
		$headings = array($lang["fld"], $lang["type"]);

		$i = 0;
	}
	function columnEditConfirmAction() {
		$query = "ALTER TABLE ".$db->quote_id($_GET['table']).' CHANGE '.$db->quote_id($_POST['oldvalue'])." ".$db->quote($_POST['0_field'])." ".$_POST['0_type'];
		$result = $db->query($query);
		if($result===false)
			$error = true;
		$completed = $lang['tbl']." '".htmlencode($_GET['table'])."' ".$lang['altered'].".";
		$backlinkParameters = "&amp;action=column_view&amp;table=".urlencode($_GET['table']);
	}
	function indexDeleteAction() {
	}
	function indexDeleteConfirmAction() {
		$query = "DROP INDEX ".$db->quote_id($_GET['pk']);
		$result = $db->query($query);
		if($result===false)
			$error = true;
		$completed = $lang['index']." '".htmlencode($_GET['pk'])."' ".$lang['deleted'].".<br/><span style='font-size:11px;'>".htmlencode($query)."</span>";
		$backlinkParameters = "&amp;action=column_view&amp;table=".urlencode($_GET['table']);
	}
	function triggerDeleteAction() {
	}
	function triggerDeleteConfirmAction() {
		$query = "DROP TRIGGER ".$db->quote_id($_GET['pk']);
		$result = $db->query($query);
		if($result===false)
			$error = true;
		$completed = $lang['trigger']." '".htmlencode($_GET['pk'])."' ".$lang['deleted'].".<br/><span style='font-size:11px;'>".htmlencode($query)."</span>";
		$backlinkParameters = "&amp;action=column_view&amp;table=".urlencode($_GET['table']);
	}
	function triggerCreateAction() {
		if($_POST['tablename']=="")
			throw new Exception($lang['specify_tbl']);
	}
	function triggerCreateConfirmAction() {
		$str = "CREATE TRIGGER ".$db->quote($_POST['trigger_name']);
		if($_POST['beforeafter']!="")
			$str .= " ".$_POST['beforeafter'];
		$str .= " ".$_POST['event']." ON ".$db->quote_id($_GET['table']);
		if(isset($_POST['foreachrow']))
			$str .= " FOR EACH ROW";
		if($_POST['whenexpression']!="")
			$str .= " WHEN ".$_POST['whenexpression'];
		$str .= " BEGIN";
		$str .= " ".$_POST['triggersteps'];
		$str .= " END";
		$query = $str;
		$result = $db->query($query);
		if($result===false)
			$error = true;
		$completed = $lang['trigger']." ".$lang['created'].".<br/><span style='font-size:11px;'>".htmlencode($query)."</span>";
		$backlinkParameters = "&amp;action=column_view&amp;table=".urlencode($_GET['table']);
	}
	function indexCreateAction() {
		if($_POST['numcolumns']=="" || intval($_POST['numcolumns'])<=0)
			echo $lang['specify_fields'];
		else if($_POST['tablename']=="")
			echo $lang['specify_tbl'];

		$num = intval($_POST['numcolumns']);

		$table = $db->quote_id($_POST['tablename']);
		$query = "PRAGMA table_info($table)";

		$result = $db->selectArray($query);
	}
	function indexCreateConfirmAction() {
		$num = $_POST['num'];
		if($_POST['name']=="") {
			$completed = $lang['blank_index'];
		} else if($_POST['0_field']=="") {
			$completed = $lang['one_index'];
		} else {
			$str = "CREATE ";
			if($_POST['duplicate']=="no") {
				$str .= "UNIQUE ";
			}
			$str .= "INDEX ".$db->quote($_POST['name'])." ON ".$db->quote_id($_GET['table'])." (";
			$str .= $db->quote_id($_POST['0_field']).$_POST['0_order'];
			for($i=1; $i<$num; $i++) {
				if($_POST[$i.'_field']!="")
					$str .= ", ".$db->quote_id($_POST[$i.'_field']).$_POST[$i.'_order'];
			}
			$str .= ")";
			$query = $str;
			$result = $db->query($query);
			if($result===false)
				$error = true;
			$completed = $lang['index']." ".$lang['created'].".<br/><span style='font-size:11px;'>".htmlencode($query)."</span>";
		}
		$backlinkParameters = "&amp;action=column_view&amp;table=".urlencode($_GET['table']);
	}
}

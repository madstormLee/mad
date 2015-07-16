<?
class DbController extends MadController {
	function indexAction() {
		$config = new MadJson( $this->project->id . '/config.json' );
		$this->view->list = $config->databases;
	}
	function databasesAction() {
	}
	function definitionListAction() {
	}
	function commonTablesAction() {
		foreach( $this->databases as $localeCode => $dbh ) {
			if ( $localeCode == 'default' ) {
				continue;
			}
			$json = new MadJson("json/LocaleTable/$dbh->host.tableIndex.json");
			if ( $json->isFile() ) {
				continue;
			}
			$list = new LocaleTableList( $this->get );
			$list->setDatabase( $localeCode );
			$list->limit();

			$tables = array();
			foreach( $list as $row ) {
				$tables[] = $row->table_name;
			}
			$json->setData($tables)->save();
		}

		/****************** getCommonTable *******************/
		$list = new MadJson("json/LocaleTable/commonTable.json");
		if ( ! $list->isFile() ) {
			$commonTable = array();
			foreach( $this->databases as $localeCode => $dbh ) {
				if ( $localeCode == 'default' ) {
					continue;
				}
				$json = new MadJson("json/LocaleTable/$dbh->host.tableIndex.json");
				if ( empty( $commonTable ) ) {
					$commonTable = $json->getArray();
					continue;
				}
				$commonTable = array_intersect( $commonTable, $json->getArray() );
			}
			sort( $commonTable );
			$list->setData( $commonTable )->save();
		}
		$this->view->list = $list;

	}
	function globalizeTableAction() {
		if ( ! $table = $this->get->table ) {
			throw new Exception('No table name!' );
		}
		$columns = array();
		foreach( $this->databases as $localeCode => $dbh ) {
			if ( $localeCode == 'default' ) {
				continue;
			}
			$db = MadDb::create()->setDatabase( $localeCode );
			$q = $db->explain( $table );
			$q->index('column_name');

			if ( empty( $columns ) ) {
				print "$localeCode is base of $table table";
				print BR;
				$columns = $q->getData();
				continue;
			}
			foreach( $q as $key => $row ) {
				if ( ! isset( $columns[$key] ) ) {
					print "$localeCode has new row $row->column_name";
					print BR;
					$columns[$key] = $row;
				}
			}
		}

		$query = array();
		$query[] = 'locale character(2)';
		foreach( $columns as $row ) {
			if( $row->data_type == 'character varying' ) {
				$datatype = "$row->data_type($row->character_maximum_length)";
			} else {
				$datatype = $row->data_type;
			}
			$query[] = "$row->column_name $datatype";
		}
		$query = implode( ",\r", $query );
		$query = "CREATE TABLE $table ( $query )";
		// print nl2br($query);
		$file = "schemes/$table.sql";
		if( ! is_file( $file ) ) {
			file_put_contents( $file, $query );
		}
		$db = MadDb::create();
		$db->exec( $query );
		$this->js->alert( "Created $table table!" )->replaceBack();
	}
	function mockupablesAction() {
		$commonTable = new MadJson("json/LocaleTable/commonTable.json");
		$tables = new LocaleTableList( $this->get );
		$tables->limit();
		$db = MadDb::create();

		$list = array();
		foreach( $tables as $row ) {
			if ( $commonTable->in( $row->table_name) ) {
				$list[] = array(
						'table' => $row->table_name,
						'total' => $db->total( $row->table_name ),
						'isScheme' => is_file( "schemes/$row->table_name.sql" ) ? 'yes': 'no',
						);
			}
		}
		$this->view->list = new MadData( $list );
	}
}

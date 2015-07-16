<?
class PostgreController extends MadController {
	function classAction() {
		$query = "SELECT 
			nspname AS schemaname,relname, cast( reltuples as bigint )
			FROM pg_class C
			LEFT JOIN pg_namespace N ON (N.oid = C.relnamespace)
			WHERE 
			nspname NOT IN ('pg_catalog', 'information_schema') AND
			relkind='r'

			ORDER BY schemaname, reltuples DESC;"
		$this->main->list = MadDb::create()->query( $query )->getData();
	}
	function procAction() {
		$this->db->query("SELECT * FROM pg_proc")->test();
		$searchWord = 'happyitem_log';
		$query = "select * from pg_proc where prosrc like '%happyitem_log%'";
	}
}

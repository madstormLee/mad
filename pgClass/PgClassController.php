<?
class PgClassController extends MadController {
	function indexAction() {
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
}

<?
class TestController extends MadController {
	function indexAction() {
		$this->view->actions = $this->getActions();
	}
	function projectQAction() {
		$projectQ = new ProjectQ("show databases");
		foreach( $projectQ->toArray() as $row ) {
			printR( $row );
		}
		die;
	}
	function ermAction() {
		$file =  "erm/user.erm";
		$test = simplexml_load_file( $file );
		$test = $test->contents;
		$table0 = $test->table[0];
		printR( $table0 );
	}
}

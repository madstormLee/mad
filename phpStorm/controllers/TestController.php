<?
class TestController extends Preset {
	function __construct() {
		parent::__construct();
	}
	function projectQAction() {
		$projectQ = new ProjectQ("show databases");
		foreach( $projectQ->toArray() as $row ) {
			printR( $row );
		}
		die;
	}
	function fetchAction() {
		include "controllers/IndexController.php";
		$test = new IndexController;
		return $test->indexAction();
	}
	function indexAction() {
		return $this->getControllerNavi();
	}
	function ajaxTreeAction() {
		$js = MadJs::getInstance();
		$js->add('/mad/js/jquery');
		print $js;
		return "
		<div id='fileTree'>
		</div>
		<script>
		$(document).ready( function() {
			    $('#fileTree').fileTree({ root: '/' }, function(file) {
					        alert(file);
							    });
		});
		</script>
		";
	}
	function testAction() {
		return 'tested';
	}
	function jsonEncodeAction() {
		$data = array(
				'test' => 'tested',
				'test2' => 'tested2',
				);
		return json_encode( $data );
	}
	function ermAction() {
		$file =  "erm/user.erm";
		$test = simplexml_load_file( $file );
		$test = $test->contents;
		$table0 = $test->table[0];
		printR( $table0 );
	}
	private function getControllerNavi() {
		$actions = $this->getActions();
		$data = array();
		foreach( $actions as $action ) {
			$actionPath = "~/$this->controllerName/$action";
			$data[$action] = $actionPath;
		}
		return new MadTag_Ul( $data );
	}
}

<?
class ViewController extends MadController {
	function indexAction() {
	}
	function viewAction() {
		$html = "file doesn't exists";
		$target = ROOT . $_SERVER['REQUEST_URI'];
		if ( is_file( $target ) ) {
			$escapes = array( 
				'<?' => '&lt;?',
				'?>' => '?&gt;',
				);
			$html = str_replace( array_keys( $escapes ), array_values( $escapes ),  file_get_contents( $target ) );
		}
		return $html;
	}
	function __call( $method, $args ) {
		return $this->viewAction();
	}
}

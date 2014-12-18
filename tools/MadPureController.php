<?
class MadPureController extends MadController {
	function __construct( $name ='' ) {
		$this->dir = $name;
	}
	function indexAction() {
		return $this->__call( 'index', array() );
	}
	function __call( $method, $args ) {
		$name = substr( $method, 0, -6 );
		$controller = "$this->dir/$this->action.php";
		$view = "$this->dir/$this->action.html";
		if( is_file( $controller ) ) {
			return new MadView( $controller );
		} elseif ( is_file( $view ) ) {
			return new MadView( $view );
		}
	}
}

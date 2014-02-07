<?
class ComponentNavi extends MadView {
	function __construct( MadController $controller ) {
		parent::__construct( 'views/componentNavi.html' );
		$this->data = $controller->getActions();
	}
}

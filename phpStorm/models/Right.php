<?
class Right extends MadView {
	function __construct( $view = 'views/right' ) {
		parent::__construct( $view );
		$this->windows = new MadData;
	}
	function addWindow( $title, $url ) {
		$this->windows->$title = $url;
	}
}

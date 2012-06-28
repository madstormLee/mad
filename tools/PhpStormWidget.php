<?
class PhpStormWidget {
	private $view;
	private $phpStorm;
	function __construct( PhpStorm $phpStorm ) {
		$this->phpStorm = $phpStorm;
		MadJs::getInstance()->add( '/mad/phpStorm/js/Widget/base' );
		MadCss::getInstance()->add( '/mad/phpStorm/css/Widget/base' );
		$this->view = new MadView( MAD . 'phpStorm/views/Widget/index' );
	}
	function __toString() {
		return "$this->view";
	}
}

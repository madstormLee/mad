<?
class PhpStormMenu extends MadSitemap {
	function __construct() {
		$json = MAD . 'phpStorm/json/Widget/sitemap';
		parent::__construct( $json );
		MadJs::getInstance()
			->addFirst('/mad/js/prototype')
			->add('/mad/js/tools')
			->add('/mad/phpStorm/js/PhpStormMenu/base');
		MadCss::getInstance()->add('/mad/phpStorm/css/PhpStormMenu/base');
	}
}

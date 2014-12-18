<?
class MadAjaxWidget {
	function __construct( $href ) {
		MadJs::getInstance()->add('/mad/js/tools')
			->add('/mad/js/FileBrowser/index');
		MadCss::getInstance()->add('/mad/css/FileBrowser/index');
	}
}

<?
class ControlController extends Preset {
	function __construct() {
		parent::__construct();
	}
	function indexAction() {
		return '<a href="~/control/sitemap">sitemap</a>';
	}
	function sitemapAction() {
		$naviData = json_decode( file_get_contents( 'configs/json/Control/sitemap.json'), true );
		return new MadNavi( $naviData );
	}
}

<?
class Sitemap extends MadModel {
	function getIndex() {
		return new MadJson( 'sitemap.json' );
	}
}

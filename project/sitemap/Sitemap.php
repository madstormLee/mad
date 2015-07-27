<?
class Sitemap extends MadModel {
	private $dir='.';
	function setDir( $dir ) {
		$this->dir = $dir;
	}
	function getIndex() {
		$rv = new MadSitemap( $this->dir . '/sitemap.json' );
		return $rv;
	}
}

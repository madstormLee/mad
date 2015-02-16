<?
class Images extends MadDir {
	protected $dir;
	function getIndex() {
		$rv = new MadDir( $this->dir );
		$rv->setPattern('*.{gif,png,jpg}');
		$rv->setFlag(GLOB_BRACE);
		return $rv;
	}
}

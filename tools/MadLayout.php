<?
class MadLayout extends MadView {
	private $dir = 'data/layouts';
	private $layout = 'Default';

	function __construct( $layout = 'Default' ) {
		$this->layout = $layout;
	}
	function setDir( $dir ) {
		$this->dir = $dir;
		return $this;
	}
	function getDir() {
		return $this->dir;
	}
	function getContents() {
		$dir = "$this->dir/$this->layout";
		$json = new MadJson( "$dir/config.json" );
		if ( ! $json->layout ) {
			$file = "$dir/layout.html";
		} else {
			$file = "$dir/$json->layout";
		}
		$this->setView( $file );
		return parent::getContents();
	}
}

<?
class Layout {
	protected $dir = '';
	function __construct() {
		$this->dir = dirName( __file__ );
	}
}

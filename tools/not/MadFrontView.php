<?
class MadFrontView {
	const EMPTY_LAYOUT = '';
	protected $data = array();
	function __construct() {
	}
	function addView( MadView $view ) {
		$this->data[] = $view;
	}
	function __toString() {
	}
}

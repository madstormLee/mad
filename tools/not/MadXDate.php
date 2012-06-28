<?
class MadXDate extends MadXUnit {
	function __construct() {
		parent::__construct();
	}
	function __toString() {
		$tag = $this->tag;
		$rv = "
		<input type='text' class='MadXDate' id='$tag->id' name='$tag->name' value='$tag->value' />
		<a class='btnMadXDate' href='#MadXDate'>선택</a>
		";
		return $rv;
	}
}

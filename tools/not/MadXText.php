<?
class MadXText extends MadXUnit {
	function __construct() {
		parent::__construct();
	}
	function __toString() {
		$this->tag->setTag('input');
		$this->tag->type = 'text';
		$this->tag->value = $this->default;
		return parent::__toString();
	}
}

<?
class MadXSelect extends MadXUnit {
	function __construct() {
		parent::__construct();
	}
	function __toString() {
		$this->tag->setTag('select');
		foreach( $this->data as $value => $option ) {
			$child = new MadTag;
			$child->setTag('option');
			$child->value = $value;
			$child->setInnerHTML($option);

			$this->tag->addChild($child);
		}
		return parent::__toString();
	}
}

<?
class MadXCheckbox extends MadXUnit {
	function __construct() {
		parent::__construct();
	}
	function toCheckboxes() {
		$this->tag->setTag('feildset');
		$i = 0;
		foreach( $this->data as $value => $label ) {
			$id = $this->tag->id . $i;
			$cbLabel = new MadXLabel;
			$cbLabel->for = $id;
			$cbLabel->setInnerHTML($label);

			$child = new MadTag;
			$child->id = $id;
			$child->name = $this->tag->name . '[]';
			$child->setTag('input');
			$child->type = 'checkbox';
			$child->value = $value;
			if ( $this->default->isValue($value) ) {
				$child->checked = 'checked';
			}

			$this->tag->addChild($child);
			$this->tag->addChild($cbLabel);
			++$i;
		}
		$this->tag->removeAttribute('name');
	}
	function __toString() {
		if ( empty( $this->data ) ) {
			return '';
		} else {
			if ( isArray( $this->data ) ) {
				$this->toCheckboxes();
			} else {
				$this->tag->setTag('input');
				$this->tag->type = 'checkbox';
				$this->tag->value = $this->data;
			}
		}
		return parent::__toString();
	}
}

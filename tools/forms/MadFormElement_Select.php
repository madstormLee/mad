<?
class MadFormElement_Select extends MadFormElement {
	function __construct( MadData $data = null ) {
		parent::__construct( $data );
		$this->attributes->setData( array(
			'id' => true,
			'name' => true,
			'type' => true,
			'readonly' => true,
			'value' => true,
			));
	}
	function get() {
		$name = ( $this->name ) ? "name='$this->name'": '';
		$rv = "<select id='$this->id' $name>";
		foreach( $this->options as $option ) {
			$checked = ( $option->value == $this->value ) ? 'selected=true': '';

			$rv .= "<option value='$option->value' $checked>$option->label</option>";
		}
		return $rv;
	}
}


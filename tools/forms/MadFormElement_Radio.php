<?
class MadFormElement_Radio extends MadFormElement {
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
	function getOptions() {
		$options = '';
		foreach( $this->options as $option ) {
			$id = $this->id . $option->value;
			$checked = ( $option->value == $this->value ) ? 'checked=true': '';

			$options .= "<li>
			<input type='radio' id='$id' name='$this->id' value='$option->value' $checked />
			<label class='radio' for='$id'>$option->label</label>
			</li>";
		}
		return $options;
	}
	function get() {
		$tag = new MadTag('ul');
		$tag->class = 'radioList';
		$tag->id = $this->id;
		$tag->update( $this->getOptions() );

		return $tag->__toString();
	}
}

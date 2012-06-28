<?
class MadFormElement_Text extends MadFormElement {
	function __construct( MadData $data = null ) {
		parent::__construct( $data );
		$this->attributes->setData( array(
			'id' => true,
			'name' => true,
			'type' => true,
			'placeholder' => true,
			'readonly' => true,
			'value' => true,
			));
	}
	function get() {
		$tag = new MadTag('input');
		foreach( $this->data as $attribute => $value ) {
			if ( true === $this->attributes->$attribute ) {
				$tag->$attribute = $value;
			}
		}
		return $tag->__toString();
	}
}

<?
class MadFormElement_Textarea extends MadFormElement {
	function __construct( MadData $data = null ) {
		parent::__construct( $data );
		$this->attributes->setData( array(
			'id' => true,
			'name' => true,
			'type' => true,
			'placeholder' => true,
			'readonly' => true,
			'class' => true,
			));
	}
	function get() {
		$tag = new MadTag('textarea');
		foreach( $this->data as $attribute => $value ) {
			if ( $attribute == 'value' ) {
				$tag->update( $value );
				continue;
			}
			if ( true === $this->attributes->$attribute ) {
				$tag->$attribute = $value;
			}
		}
		if ( ! $tag->name && $this->id ) {
			$tag->name = $this->id;
		}
		return "$tag";
	}
}

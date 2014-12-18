<?
class MadFormElement_Hidden extends MadFormElement {
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
		$tag = new MadTag('input');
		$tag->type = 'hidden';
		foreach( $this->data as $attribute => $value ) {
			if ( true === $this->attributes->$attribute ) {
				$tag->$attribute = $value;
			}
		}
		if ( ! $tag->name && $this->id ) {
			$tag->name = $this->id;
		}
		return $tag->__toString();
	}
}

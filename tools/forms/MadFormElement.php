<?
abstract class MadFormElement {
	protected $data = null;
	protected $attributes;

	function __construct( MadData $data = null ) {
		$this->data = new MadData;
		$this->setData( $data );
		$this->attributes = new MadData;
	}
	function setData( MadData $data = null ) {
		if ( ! is_null( $data ) ) {
			$this->data = $data;
		}
		return $this;
	}
	function getData() {
		return $this->data;
	}
	function isEmpty() {
		return $this->data->isEmpty();
	}
	function label() {
		return $this->getLabel();
	}
	function getLabel() {
		$label = new MadTag('label');
		$label->for = $this->id;
		$label->update( $this->data->label );
		return $label;
	}
	function __get( $key ) {
		return $this->data->$key;
	}
	function __set( $key, $value ) {
		$this->data->$key = $value;
	}
	abstract function get();
	public final function __toString() {
		return $this->get();
	}
}

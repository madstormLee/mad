<?
class MadTag {
	protected $tag;
	protected $children = array();
	protected $innerHTML = '';
	protected $attributes = array();

	function __construct() {
	}
	function __get( $key ) {
		return $this->getAttribute($key);
	}
	function __set( $key, $value ) {
		$this->addAttribute($key, $value);
	}
	function setTag( $tag ) {
		$this->tag = $tag;
		return $this;
	}
	function getTag() {
		return $this->tag;
	}
	function setInnerHTML( $innerHTML ) {
		$this->innerHTML = $innerHTML;
		return $this;
	}
	function getInnerHTML( $innerHTML ) {
		return $this->innerHTML;
	}
	function setAttribute( $attribute, $value ) {
		$this->attributes[$attribute] = $value;
		return $this;
	}
	function addAttribute( $attribute, $value ) {
		$this->attributes[$attribute] = $value;
		return $this;
	}
	function getAttribute( $attribute ) {
		return ckKey( $attribute, $this->attributes );
	}
	function removeAttribute( $attribute ) { 
		if ( isset( $this->attributes[$attribute] ) ) {
			unset( $this->attributes[$attribute] );
		}
		return $this;
	}
	public function addChild( self $child ) {
		$this->children[] = $child;
		return $this;
	}
	protected final function getAttributesText() {
		$rv = array();
		if ( empty( $this->attributes ) ) {
			return '';
		}
		foreach( $this->attributes as $attribute => $value ) {
			$rv[] = $attribute . '="' . $value . '"';
		}
		return ' ' . implode(' ' , $rv);
	}
	public function get() {
		if ( empty( $this-> tag ) ) {
			return '';
		}
		$rv = "<$this->tag";
		$rv .= $this->getAttributesText();
		$rv .= ">" . $this->getBody() . "</$this->tag>";
		return $rv;
	}
	protected function getBody() {
		return $this->innerHTML . implode( $this->children );
	}
	protected function hasBody() {
		if ( empty( $this->children ) && empty( $this->innerHTML ) ) {
			return false;
		}
		return true;
	}
	public final function __toString() {
		return $this->get();
	}
}

<?
class MadTag {
	private $tagName;
	private $attributes;
	private $children = array();
	private $innerHTML;
	private $singleTags = array(
		'input',
		'br',
	);

	function __construct( $tagName = 'div' ) {
		$this->tagName = strToLower( $tagName );
	}
	function __get( $key ) {
		return $this->getAttribute($key);
	}
	function __set( $key, $value ) {
		$this->addAttribute($key, $value);
	}
	function setTagName( $tagName ) {
		$this->tagName = $tagName;
		return $this;
	}
	function getTagName() {
		return $this->tagName;
	}
	function update( $innerHTML ) {
		$this->setInnerHTML( $innerHTML );
	}
	function setInnerHTML( $innerHTML ) {
		$this->innerHTML = $innerHTML;
		return $this;
	}
	function getInnerHTML() {
		return $this->innerHTML;
	}
	function addAttribute( $attribute, $value ) {
		$this->attributes[$attribute] = $value;
		return $this;
	}
	function setAttribute( $attribute, $value ) {
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
			$rv[] = $attribute . "='$value'";
		}
		return implode(' ' , $rv);
	}
	protected function getBody() {
		return $this->innerHTML;
		$temp = implode( $this->children );
	}
	protected function hasBody() {
		if ( empty( $this->children ) && empty( $this->innerHTML ) ) {
			return false;
		}
		return true;
	}
	public function get() {
		if ( empty( $this->tagName ) ) {
			return '';
		}
		$attributesText = $this->getAttributesText();
		if ( in_array( $this->tagName, $this->singleTags ) ) {
			return "<$this->tagName $attributesText />";
		}
		return "<$this->tagName $attributesText>" . $this->getBody() . "</$this->tagName>";
		return $rv;
	}
	public final function __toString() {
		return $this->get();
	}
}

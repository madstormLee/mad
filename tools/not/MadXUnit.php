<?
class MadXUnit {
	protected $tag;
	protected $label;
	protected $default = array();
	protected $data = array();
	protected $js;
	protected $style;

	function __construct() {
		$this->js = JsManager::getInstance();
		$this->style = CssManager::getInstance();
		$this->js->set('/mad/js/XForm/base');
		$this->style->set('/mad/css/XForm/base');
		$this->tag = new MadTag;
		$this->label = new MadXLabel;
	}
	public function __set( $key, $value ) {
		$this->tag->setAttribute( $key, $value );
	}
	function __get( $key ) {
		if ( isset( $this->$key ) ) {
			$this->$key = $value;
		}
	}
	function setLabel( $label ) {
		$this->label->setInnerHTML($label);
	}
	function getLabel() {
		if ( is_a($this->label, 'MadXLabel') ) {
			$this->label->addAttribute('for',$this->tag->id);
		}
		return $this->label;
	}
	function setDefault( MadDic $default ) {
		$this->default = $default;
		return $this;
	}
	function setData( $data ) {
		$this->data = $data;
		return $this;
	}
	function __toString() {
		return $this->tag->get();
	}
}

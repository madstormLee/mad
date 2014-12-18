<?
/* 이것은 factory로서의 역할만 한다. */
class MadFormUnit {
	protected $type;
	protected $current;
	protected $default;

	function __construct() {
	}
	function __set( $key, $value ) {
		if ( isset( $this->$key ) ) {
			$this->$key = $value;
		}
	}
	function createUnit() {
	}
	function __toString() {
		$form = $this->createUnit();
		$form->setType( $this->type );
		return $form->get();
	}
}

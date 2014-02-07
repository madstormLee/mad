<?
class MadFormsUnit extends MadAbstractData {
	function label() {
		return "<label for='$this->id'>$this->label</label>";
	}
	function setData( $data=array() ) {
		$this->data = $data;
	}
	function get() {
		return '';
	}
	function __toString() {
		return $this->get();
	}
}

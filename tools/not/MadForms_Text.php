<?
class MadForms_Text extends MadFormsUnit {
	function get() {
		if ( ! $this->id ) {
			$this->id = $this->name;
		}
		return "<input type='text' id='$this->id' name='$this->name' value='$this->default' />";
	}
}

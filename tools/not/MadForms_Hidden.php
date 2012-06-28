<?
class MadForms_Hidden extends MadFormsUnit {
	function get() {
		if ( ! $this->id ) {
			$this->id = $this->name;
		}
		return "<input type='hidden' id='$this->id' name='$this->name' value='$this->default' />";
	}
}

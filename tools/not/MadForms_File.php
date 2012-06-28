<?
class MadForms_File extends MadFormsUnit {
	function get() {
		if ( ! $this->id ) {
			$this->id = $this->name;
		}
		return "<input type='file' id='$this->id' name='$this->name' />";
	}
}

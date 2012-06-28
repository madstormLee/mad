<?
class MadForms_Textarea  extends MadFormsUnit {
	function get() {
		if ( empty( $this->id ) ) {
			$this->id = $this->name;
		}
		$rv = "<textarea id='$this->id' name='$this->name'>$this->default</textarea>";
		return $rv;
	}
}

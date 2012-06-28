<?
class MadForms_Text extends MadFormsUnit {
	function get() {
		if ( ! $this->id ) {
			$this->id = $this->name;
		}
		if( ! is_array( $this->options ) ){
			$this->options = explode(',',$this->options);
		}
		$selected = '';
		$rv = "<fieldset id='$this->name'><legend>$this->name</legend>";
		$i = 0;
		foreach( $this->dictionary as $key => $value ) {
			$checked = ( $key == $this->current ) ? ' checked="checked"' : '';
			$id = $this->name.$i;
			$rv .= "<input type='radio' class='$this->name' id='$id' name='$this->name' value='$key' $checked /><label for='$id' class='$id'>$value</label>";
			$i++;
		}
		$rv .= "</fieldset>";
		return $rv;
	}
}

<?
class MadForm {
	function input( $type='text', $name='id', $value='', $id='' ) {
		if ( empty( $id ) ) {
			$id = $name;
		}
		return "<input type='$type' id='$id' name='$name' value='$value' />";
	}
	function hidden( $name , $value='', $id='') {
		return "<input type='hidden' id='$name' name='$name' value='$value' />";
	}
	function text( $name , $value='', $id='') {
		$rv = "<input type='text' id='$id' name='$name' value='$value' />";
		return $rv;
	}
	function password( $name , $value='', $id='') {
		if ( empty( $id ) ) {
			$id = $name;
		}
		$rv = "<input type='password' id='$id' name='$name' value='$value' />";
		return $rv;
	}
	function phone( $name, $value='' ) {
		(string) $value;

		if ( strlen ( $value ) > 8 ) {
				$firstStop = 3;
			if ( substr($value, 0,2) == '02' ) { //국번이 '02'인 경우만 처음을 2숫자로 한다.
				$firstStop = 2;
			}
			$leftValue = substr($value,$firstStop);
			if ( strlen($leftValue) < 8 ) { // 남은게 8개 미만이면 3과 나머지를 전화번호로 한다.
				$secondStop = 3;
			} else {
				$secondStop = 4;
			}
			$phone[] = substr($value,0,$firstStop);
			$phone[] = substr($leftValue,0,$secondStop);
			$phone[] = substr($leftValue,$secondStop);
		}
		$rv = array();
		for ( $i = 0; $i < 3; ++$i ) {
			$id = $name.$i;
			$rv[] = "<input type='text' class='phone' id='$id' name='{$name}[]' value='$phone[$i]' maxlength='4' />";
		}
		$rv = implode(' - ',$rv);
		return $rv;
	}
	function date( $name, $value='') {
		date_default_timezone_set('Asia/Seoul');
		if ( empty( $value ) ) $value = date('Y-m-d');
		$rv = "<input type='text' id='$name' name='$name' value='$value' />";
		return $rv;
	}
	function textarea( $name , $value='') {
		$rv = "<textarea id='$name' name='$name'>$value</textarea>";
		return $rv;
	}
	function submit( $value ) {
		$rv = "<input type='submit' value='$value' />";
		return $rv;
	}
	function select( $name , $options , $current=0, $id='') {
		if ( empty($id) ) {
			$id = $name;
		}
		$selected = '';
		if( ! isArray( $options ) ){
			$options = explode(',',$options);
		}
		$rv = "<select id='$id' name='$name'>";
		foreach( $options as $key => $value ) {
			$selected = ( $key == $current ) ? ' selected' : '';
			$rv .= "<option value='$key'$selected>$value</option>";
		}
		$rv .= "</select>";
		return $rv;
	}
	function checkbox( $name , $option='' , $value=0) {
		$checked = '';
		if ( $value == 1 ) $checked = ' checked';
		$rv = "<input type='checkbox' id='$name' name='$name' value='1' $checked />
			<label for='$name'>$option</label>";
		return $rv;
	}
	function checkboxes( $name, $options, $currents = array() ) {
		if( ! isArray( $options ) ){
			$options = explode(',',$options);
		}
		$selected = '';
		$rv = "<fieldset><legend>$name</legend>";
		$i = 0;
		foreach( $options as $key => $value ) {
			$checked = ( in_array( $key, $currents) ) ? ' checked' : '';
			$id = $name.$i;
			$rv .= "<input type='checkbox' class='$name' id='$id' name='{$name}[]' value='$key' $checked />
				<label for='$id'>$value</label>";
			$i++;
		}
		$rv .= "</fieldset>";
		return $rv;
	}
	function radio( $name , $options , $current=0) {
		if( ! isArray( $options ) ){
			$options = explode(',',$options);
		}
		$selected = '';
		$rv = "<fieldset id='$name'><legend>$name</legend>";
		$i = 0;
		foreach( $options as $key => $value ) {
			$checked = ( $key == $current ) ? ' checked="checked"' : '';
			$id = $name.$i;
			$rv .= "<input type='radio' class='$name' id='$id' name='$name' value='$key' $checked /><label for='$id' class='$id'>$value</label>";
			$i++;
		}
		$rv .= "</fieldset>";
		return $rv;
	}
}

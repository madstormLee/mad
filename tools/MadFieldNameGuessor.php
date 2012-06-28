<?
class MadFieldNameGuessor {
	private $typicalFields;
	function __construct() {
		$this->typicalFields = new MadIni('configs/ini/typicalFields.ini');
	}
	function guess( $field, $type = '' ) {
		if ( $this->typicalFields->$field ) {
			return $this->typicalFields->$field->method;
		} else if ( 0 === strpos( $field, 'varchar' ) ) {
			return 'getJunkText';
		} else if ( false !== preg_match( '/date$/i', $field ) || 0 === stripos( $type, 'datetime' ) ) {
			return 'getDate';
		} else if ( false !== preg_match( '/int$/i', $type ) ) {
			return 'getNumber';
		}
		return 'getJunkText';
	}
}

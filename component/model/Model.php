<?
class Model {
	private $file;
	private $data;

	function __construct( $file ) {
		$this->file = $file;
		$this->data = file_get_contents( $file );
	}
	function getFile() {
		return $this->file;
	}
	function getDefaultFields() {
		return new MadJson('component/model/defaultFields.json');
	}
	function getExtends() {
		$cnt = preg_match('/(?<=extends )[A-ZA-z0-9_]+/', $this->data, $matches );
		if ( $cnt > 0 ) {
			return array_pop( $matches );
		}
		return '';
	}
	function getName() {
		$cnt = preg_match('/(?<=class )[A-ZA-z0-9_]+/', $this->data, $matches );
		if ( $cnt > 0 ) {
			return array_pop( $matches );
		}
		return '';
	}
	function getMethods() {
		$cnt = preg_match_all('/(?<=function )\s*[A-ZA-z0-9_]+/', $this->data, $matches );

		if ( $cnt > 0 ) {
			return new MadData( current($matches) );
		}
		return array();
	}
}

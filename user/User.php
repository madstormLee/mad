<?
class User {
	private $dir = '';
	private $file = '';

	private $data = null;
	private $extension = '.json';

	function __construct( $id = '' ) {
		$this->dir = __dir__ . '/data';
		$this->fetch( $id );
	}
	function getList() {
		return glob( "$this->dir/*$this->extension");
	}
	function logout() {
		$this->data = null;
	}
	function fetch( $id ) {
		if ( empty( $id ) ) {
			return false;
		}
		$this->id = $id;
		$this->file = "$this->dir/$id.json";
		if ( ! is_file( $this->file ) ) {
			return false;
		}
		$this->data = new MadJson( $this->file );
		return true;
	}
	function __get( $key ) {
		if ( $this->data && $this->data->$key ) {
			return $this->data->$key;
		}
		return false;
	}
}

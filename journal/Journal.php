<?
class Journal {
	private $dir = 'Journal/data';
	private $file = '';

	private $data = array();
	private $extension = '.txt';

	function __construct( $id = '' ) {
		$this->dir = __dir__ . '/data';
		if ( ! $id ) {
			$id = date('Ymd_His');
		}
		$this->fetch( $id );
	}
	function setData( $data ) {
		$this->data = $data;
		return $this;
	}
	function getFile() {
		return $this->file;
	}
	function isFile() {
		return is_file( $this->file );
	}
	function getBasename() {
		return basename( $this->file );
	}
	function getList() {
		return glob( "$this->dir/*$this->extension");
	}
	function fetch( $id ) {
		if ( empty( $id ) ) {
			return false;
		}
		$this->id = $id;
		$this->file = "$this->dir/$id.txt";
		if ( ! is_file( $this->file ) ) {
			return false;
		}
		$this->contents = file_get_contents( $this->file );
		return true;
	}
	function __set( $key, $value ) {
		$this->data[$key] = $value;
	}
	function __get( $key ) {
		if( isset( $this->data[$key] ) ) {
			return $this->data[$key];
		}
		return '';
	}
	function save() {
		return file_put_contents( $this->file, $this->contents );
	}
	function delete() {
		if ( is_file( $this->file ) ) {
			return unlink( $this->file );
		}
		return false;
	}
	function __toString() {
		return htmlEntities($this->contents, ENT_QUOTES | ENT_IGNORE, 'UTF-8');
	}
}

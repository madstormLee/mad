<?
class Journal extends MadFile {
	protected $dir = 'Journal/data';
	protected $file = '';

	protected $data = array();
	protected $extension = '.txt';

	function __construct( $id = '' ) {
		$this->dir = __dir__ . '/data';
		if ( empty($id) ) {
			$id = date('Ymd_His');
		}
		$this->fetch( $id );
	}
	function setData( $data ) {
		$this->data = $data;
		return $this;
	}
	function getIndex() {
		return glob( "$this->dir/*$this->extension");
	}
	function fetch( $id ) {
		if ( empty( $id ) ) {
			return false;
		}
		$this->id = $id;
		$this->file = "$this->dir/$id.txt";
		if ( ! $this->isFile() ) {
			return false;
		}
		$this->contents = $this->getContents();
		return true;
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

<?
class Backlog extends MadModel {
	private $dir = 'Backlog/data';
	private $file = '';
	private $extension = '.json';
	private $data = array();

	function __construct( $id = '' ) {
		$this->data = new MadJson;
		$this->dir = __dir__ . '/data';
		$this->fetch( $id );
	}
	function getList() {
		return glob( "$this->dir/*$this->extension");
	}
	function setData( $data ) {
		$this->data->setData( $data );
		return $this;
	}
	function setJson( $json ) {
		$this->data->setJson( $json );
		return $this;
	}
	function getContents() {
		if ( ! empty( $this->data ) ) {
			return (string) $this->data;
		}
		return '[]';
	}
	function addText( $contents ) {
		$data = array_filter(explode("\n", $contents) );
		$item = $this->item;
		foreach( $data as $row ) {
			if ( ! preg_match( '/^[0-9]+\.\s/', $row ) ) {
				continue;
			}
			$row = preg_replace( '/^[0-9]+\.\s/', '', $row );
			$rowData = new StdClass;
			$item[] = array(
				"title" => $row,
				"status" => 'new',
				);
		}
		$this->item = $item;
		return $this->save();
	}
	function fetch( $id = '' ) {
		if ( empty( $id ) ) {
			return false;
		}
		$this->file = "$this->dir/$id.json";
		$this->data->fetch( $this->file );
		$this->id = $id;
		return true;
	}
	function save() {
		return file_put_contents( $this->file, $this->data->getJson() );
	}
	function delete() {
		return unlink( $this->file );
	}
	function __get( $key ) {
		if ( $this->data && $this->data->$key ) {
			return $this->data->$key;
		}
		return false;
	}
	function __set( $key, $value ) {
		$this->data->$key = $value;
	}
	function __toString() {
		return $this->getContents();
	}
}

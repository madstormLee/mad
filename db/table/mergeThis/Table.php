<?
class Table extends Mad {
	private $table = '';
	private $data = null;

	function __construct( $table = '') {
		$this->table = $table;
		$this->data = new MadData;
	}
	function setInfo() {
		$q = new ProjectQ("select * from information_schema.TABLES where TABLE_NAME like '$this->table'");
		$this->data->addData( $q->row() );
	}
	function addData( $data = array() ) {
		$this->data->addData( $data );
	}
	function setData( $data = array() ) {
		$this->data->setData( $data );
	}
	function getList() {
		return new TableList($this);
	}
	function __set( $key, $value ) {
		$this->data->$key = $value;
	}
	function __get( $key ) {
		return $this->data->$key;
	}
	function __toString() {
		return $this->table;
	}
	function test() {
		$this->data->test();
	}
}

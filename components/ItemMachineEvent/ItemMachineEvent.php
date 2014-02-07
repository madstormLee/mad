<?
class ItemMachineEvent extends MadModel {
	function __construct( $id='' ) {
		$this->events = array();
		parent::__construct( $id );
	}
	function getCode( $id ) {
		$q = MadDb::create()->query("select client_code from $this->table where id=$id");
		return $q->getFirst();
	}
	function fetch( $id ) {
		parent::fetch( $id );
		$this->events = explode(',', $this->events);
	}
	function insert() {
		if ( $this->events ) {
			$this->events = $this->events->implode(',');
		}
		$data = $this->data;
		unset( $data[$this->primaryKey] );

		$keys = implode( ',', array_keys( $data ) );
		$values = implode( ',', $this->escape( array_values( $data ) ) );

		$q = MadDb::create()->query( "insert into $this->table ($keys) values ($values)" );
		$this->{$this->primaryKey} = $q->getInsertId( $this->table . '_' . $this->primaryKey . '_seq' );
		return $q->rows();
		return parent::insert();
	}
	function update() {
		if ( $this->events ) {
			$this->events = $this->events->implode(',');
		}
		return parent::update();
	}
	function delete( $key ) {
		$key = pg_escape_string( $key );
		$q = MadDb::create()->query( "delete from $this->table where $this->primaryKey='$key'" );
		return $q->rows();
	}
}

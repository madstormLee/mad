<?
class MadMapModel extends MadModel {
	protected $idName = 'id';
	protected $relName = 'relid';

	public function insert() {
		$keys = implode( ',', array_keys( $this->data ) );
		$values = implode( ",", $this->escape( array_values( $this->data ) ) );
		$query = "insert into $this->table ($keys) values ($values)";
		return $this->db->exec( $query );
	}
	function getIds( $relId ) {
		if ( empty( $relId ) ) {
			return new MadData;
		}
		$query = "select \"$this->idName\" from \"$this->table\" where $this->relName='$relId'";
		return $this->db->query( $query )->getData()->dic( $this->idName );
	}
	function getRelIds( $id ) {
		if ( empty( $id ) ) {
			return new MadData;
		}
		$query = "select \"$this->relName\" from \"$this->table\" where $this->idName='$id'";
		return $this->db->query( $query )->getData()->dic( $this->idName );
	}
	function insertMap( $id, $relId ) {
		if ( empty( $relId ) ) {
			return 0;
		}
		$idName = $this->idName;
		$relName = $this->relName;

		$this->$idName = $id;
		if ( ! is_array( $relId ) ) {
			$this->$relName = $relId;
			return $this->insert();
		}
		$rv = 0;
		foreach( $relId as $value ) {
			$this->$relName = $value;
			$rv += $this->insert();
		}
		return $rv;
	}
	// this is not multiple insertion.
	function insertMapSafe( $id, $relId ) {
		if ( ! $this->db->total( $this->table, "$this->idName='$id' and $this->relName ='$relId'" ) ) {
			$this->insertMap( $id, $relId );
		}
		return false;
	}
	public function deleteId( $key ) {
		$key = $this->escape( $key );
		$q = $this->db->query( "delete from $this->table where $this->idName=$key" );
		return $q->rows();
	}
}

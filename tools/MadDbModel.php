<?
class MadDbModel extends MadModel {
	protected $data;

	protected $table;
	protected $query;
	protected $keyField = 'no';

	function __construct() {
		parent::__construct();
		$this->table = get_class($this);
	}
	/******************* getter/setter ****************/
	function getTable() {
		return $this->table;
	}
	function setTable( $table ) {
		if ( is_a( $tableName, MadDbTable ) ) {
			$this->table = $table;
		} else {
			$this->table->setTableName( $tableName );
		}
		return $this;
	}
	function getQuery() {
		return $this->query;
	}
	function getIterator() {
		return new ArrayIterator($this->data);
	}
	/********************** DMLs **********************/
	function fetch( $no ) {
		$this->data = $this->query->where("no = $no")
			->fetchObject( $this );
		return $this;
	}
	function insert() {
		$set = new MadSet( $this->data );
		$query="insert into $this->table $set";
		$q = new Q($query);
		return $q->getInsertId();
	}
	function update() {
		$set = new MadSet( $this->data );
		$key = $this->{$this->keyField};
		$query = "update $this->table $set where $this->keyField=$key";
		$q = new Q($query);
		return $q->rows();
	}
	function delete( $no ){
		if ( is_array ( $no ) ) {
			$no = implode(',', $no );
		}
		return $this->query->delete()->where( "$this->primaryKey in ($no)" )->rows();
	}
	/********************** DDLs **********************/
	function create() {
		$installer = new MadInstaller();
		$installer->install($this->table);
	}
	function drop() {
		return $this->query->drop();
	}
	function truncate() {
		return $this->query->truncate();
	}
	function explain() {
		return $this->query->explain();
	}
}

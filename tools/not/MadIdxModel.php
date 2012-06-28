<?
class MadIdxModel implements IteratorAggregate {
	protected $table;
	protected $data;

	function __construct(){
		$this->table = get_class($this);
		if ( MAD_AUTO_INSTALL && ! is_table($this->table) ) {
			$this->create();
		}
	}
	function __get( $key ) {
		if ( isset( $this->data[$key] ) ) {
			return $this->data[$key];
		}
		return false;
	}
	function __set( $key, $value ) {
		$this->data[$key] = $value;
	}
	function __isset( $key ) {
		if ( isset( $this->data[$key] ) ) {
			return true;
		}
		return false;
	}
	function get() {
		return $this->data;
	}
	function getIterator() {
		return new ArrayIterator($this->data);
	}
	function fetch( $idx ) {
		$query = "select * from $this->table where idx = $idx";
		$q = new Q($query);
		if ( $q->rows() > 0 ) {
			$this->data = $q->row();
		}
		return $this;
	}
	function create() {
		$installer = new MadInstaller();
		$installer->install($this->table);
	}
	function insert( $set ){
		$query="insert into $this->table $set";
		$q = new Q($query);
		return $q->getInsertId();
	}
	function update( $set ){
		$query = "update $this->table $set where idx=$set->idx";
		$q = new Q($query);
		return $q->rows();
	}
	function delete( $idx ){
		if ( is_array ( $idx ) ) {
			$idx = implode(',', $idx );
		}
		$query = "delete from $this->table where idx in ($idx)";
		$q = new Q($query);
		return $q->rows();
	}
	function test() {
		printR($this->data);
	}
}

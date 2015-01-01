<?
class MadDbModel extends MadModel{
	protected $table = '';
	protected $pKey = 'id';
	protected $query;

	protected $db = null;

	function __construct( $id = '' ) {
		if ( empty( $this->table ) ) {
			$this->table = get_class( $this );
		}
		$this->query = new MadQuery( $this->table );
		$this->db = $this->query->getDb();
		$this->query->setModel( $this );

		if ( ! empty( $id ) ) {
			$this->fetch( $id );
		}
	}
	public function getList() {
		return $this->query->getData();
	}
	/************************* CRUD **********************/
	public function fetch( $key = '' ) {
		if ( empty( $key ) ) {
			return $this;
		}
		$this->query->where("$this->pKey=$key")->fetch();
		return $this;
	}
	public function save( $data = null ) {
		if ( ! empty( $this->{$this->pKey} ) ) {
			return $this->update();
		}
		return $this->insert();
	}
	public function insert() {
		return $this->query->insert( $this->data )->exec();
	}
	public function update() {
		if ( ! $key = $this->{$this->pKey} ) {
			return false;
		}
		if ( $this->rollback ) {
			$this->createUpdateRollback( $key );
		}

		return $this->query->update( $this->getUpdateQuery() );
	}
	public function update2() {
		$query = new MadQuery( $this->table );
		$set = $this->getSet( $this->data );
		$result = $query->update( $set )->where( "$this->pKey=$key" )->excute();
		return $result->rows();
	}
	public function delete( $key='' ) {
		if ( is_array ( $key ) ) {
			$key = implode(',', $key );
		}
		if ( $this->rollback ) {
			$this->createDeleteRollback( $key );
		}
		$key = $this->db->escape( $key );
		return $this->query->delete( "$this->pKey in ($key)" )->exec();
	}
	public function deleteWhere( $condition ) {
		return $this->db->exec( "delete from $this->table where $condition" );
	}
	/************************* getter/setter **********************/
	function explain() {
		return $this->query->explain();
	}
	function getNextId() {
		$q = $this->db->query( "select min( $this->pKey ) from $this->table where $this->pKey > $this->id" );
		return $q->getFirst();
	}
	function getPrevId() {
		$q = $this->db->query( "select max( $this->pKey ) from $this->table where $this->pKey < $this->id" );
		return $q->getFirst();
	}
	function getColumns() {
		return $this->db->showColumns( $this->table );
	}
	function getColumnData() {
		$data = $this->data;
		$columns = $this->getColumns();
		foreach( $this->data as $key => $value ) {
			if ( ! $columns->in( $key ) ) {
				unset ( $data[$key] );
			}
		}
		return $data;
	}
	/********************** DDLs **********************/
	public function createTable() {
		$file = "$this->table/scheme.sql";
		if ( ! is_file( $file ) ) {
			throw new Exception( "File not Found." );
		}
		$query = file_get_contents( $file );
		return $this->db->exec( $query );
	}
	public function dropTable() {
		$query = "drop table $this->table";
		return $this->db->exec( $query );
	}
	public function isInstall() {
		return $this->query->isTable();
	}
	public function install() {
		$schemesDir = 'schemes/';
		$schemeFile = $schemesDir . "$this->table.sql";
		$scheme = new MadScheme( $schemeFile );
		return $scheme->install();
	}
	/*********************** getter/setter **********************/
	public final function getQuery() {
		return $this->query;
	}
	public final function setTable( $table ) {
		$this->table = $table;
		return $this;
	}
	public final function getTable() {
		return $this->table;
	}
	public final function setPKey( $pKey ) {
		$this->pKey = $pKey;
		return $this;
	}
	public final function getPKey() {
		return $this->pKey;
	}
}


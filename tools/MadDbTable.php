<?
// 이상하고 멍청할 뿐이다.
class MadDbTable extends MadData {
	protected $query;
	protected $table;
	protected $config;
	protected $primaryKey = 'no';

	function __construct( $data = array() ) {
		parent::__construct( $data );
		$this->table = get_class($this);
		$this->init();
	}
	function init() {
		$this->setConfig( new MadConfig( PhpStorm::getInstance()->getDir('configs') . $this->table ) );
		$this->query = new MadQuery( get_class($this) );
		$this->query->from( $this->table );
	}
	function setConfig( MadConfig $config ) {
		$this->config = $config;
	}
	function getConfig() {
		return $this->config;
	}
	function getModelLabel() {
		if ( $this->config->getFile() ) {
			return $this->config->label;
		}
		return false;
	}
	function getLabel( $key ) {
		if ( $this->config->columns && $this->config->columns->$key ) {
			return $this->config->columns->$key->label;
		}
		return false;
	}
	function setTable( $table ) {
		$this->query->from( $table );
		return $this;
	}
	function getTable() {
		return $this->query->getTable();
	}
	function setPrimaryKey( $key ) {
		$this->primaryKey = $key;
		return $this;
	}
	function getPrimaryKey() {
		return $this->primaryKey;
	}
	function fetch( $no ) {
		if ( empty( $no ) ) {
			return $this;
		}
		$data = $this->query->where( "$this->primaryKey = $no" )
			->fetch( $this );
		$this->setData( $data );
		return $this;
	}
	function insert( $data = '' ) {
		if ( $data ) {
			$this->setData( $data );
		}
		return $this->query->insert( $this->data )->insertId();
	}
	function update( $data = '' ) {
		if ( $data ) {
			$this->setData( $data );
		}
		$key = $this->{$this->primaryKey};
		return $this->query->update( $this->data )->where( "$this->primaryKey=$key" )->rows();
	}
	function delete( $no ) {
		if ( is_array ( $no ) ) {
			$no = implode(',', $no );
		}
		return $this->query->delete()->where("$this->primaryKey in ($no)")->rows();
	}
	function create() {
		$installer = new MadInstaller();
		$installer->install($this->table);
	}
	function drop() {
		$this->query->drop();
	}
	function truncate() {
		return $this->query->truncate();
	}
	function explain() {
		return $this->query->explain();
	}
	function getList() {
		$className = $this->table . 'List';
		if ( class_exists( $className) ) {
			return new $className($this);
		} else {
			return $this->query;
		}
	}
}

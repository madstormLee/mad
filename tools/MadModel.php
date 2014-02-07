<?
//todo roll back must refactored with MadQuery
class MadModel extends MadData {
	protected $server = 'pgsql';
	protected $dbName = 'default';
	protected $table = '';
	protected $primaryKey = 'id';
	protected $config = null;
	protected $query;

	protected $db = null;
	protected $rollback = false;
	protected $rollbackQuery = '';

	function __construct( $id = '' ) {
		$g = MadGlobals::getInstance();
		$this->server = $g->databases->default->server;
		if ( ! $this->db ) {
			$this->db = MadDb::create();
		}
		if ( ! empty( $this->dbName ) ) {
			$this->db->setDatabase( $this->dbName );
		}

		$this->config = new MadJson( $g->dirs->configs . get_class($this) .'/model.json' );

		if ( empty( $this->table ) ) {
			$this->table = get_class( $this );
		}
		if ( ! empty( $id ) ) {
			$this->fetch( $id );
		}
	}
	function getQuery() {
		return $this->query;
	}
	function isInstall() {
		return $this->db->isTable( $this->table );
	}
	function install() {
		$schemesDir = 'schemes/';
		$schemeFile = $schemesDir . "$this->table.sql";
		$scheme = new MadScheme( $schemeFile );
		return $scheme->install();
	}
	public static function create( $class ) {
		if ( class_exists( $class ) ) {
			return new $class;
		}
		return new self;
	}
	function setConnectInfo( $info ) {
		$this->db->setConnectInfo( $info );
	}
	function isConfig() {
		return ! $this->config->isEmpty();
	}
	function getConfig( $target = '' ) {
		if ( empty( $target ) ) {
			return $this->config;
		}
		if ( empty( $this->config->$target ) ) {
			return new MadData;
		}
		return $this->config->$target;
	}
	function createConfig() {
		foreach( MadDb::create()->explain( $this->table )->getData() as $row ) {
			$max = 0;
			$min = 0;
			$type = 'text';
			if ( in_array( $row->data_type, array( 'smallint', 'integer', 'bigint' ) ) ) {
				$max = pow( 2, $row->numeric_precision ) / 2 - 1;
				$min = -1 * pow( 2, $row->numeric_precision ) / 2;
				$type = 'number';
			} else if ( $row->data_type == 'serial' ) {
				$max = pow( 2, $row->numeric_precision ) / 2 - 1;
				$min = 1;
				$type = 'hidden';
			} else if ( preg_match( '/^char/', $row->data_type ) ) {
				$max = $row->character_maximum_length;
				$type = 'text';
			} else if ( $row->data_type == 'text' ) {
				$type = 'textarea';
			}
			$this->config->{$row->column_name} = array(
					'id' => $row->column_name,
					'name' => $row->column_name,
					'label' => $row->column_name,
					'type' => $row->data_type,
					'max' => $max,
					'min' => $min,
					);
		}
		$this->config->save();
	}
	function select( $where ) {
		print $query = "select * from $where";
		return $this->db->query( $query )->getData();
	}
	/************************* utilities **********************/
	function getNextId() {
		$q = $this->db->query( "select min( $this->primaryKey ) from $this->table where $this->primaryKey > $this->id" );
		return $q->getFirst();
	}
	function getPrevId() {
		$q = $this->db->query( "select max( $this->primaryKey ) from $this->table where $this->primaryKey < $this->id" );
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
	/************************* CRUD **********************/
	public function fetch( $key ) {
		if ( empty( $key ) ) {
			return $this;
		}
		$key = $this->escape( $key );
		$q = $this->db->query( "select * from  \"$this->table\" where $this->primaryKey=$key" );
		$this->setData( $q->row() );
		return $this;
	}
	public function save( $data = null ) {
		if ( ! empty( $this->{$this->primaryKey} ) ) {
			return $this->update();
		}
		return $this->insert();
	}
	// this is not good idea.
	public function insertKeyValues( $values ) {
		$query = "insert into $this->table $key values $values";
		return $model->exec( $query );
	}
	public function getInsertQuery() {
		$data = $this->data;
		unset( $data[$this->primaryKey] );

		$keys = implode( ',', $this->escapeFields( array_keys( $data ) ) );
		$values = implode( ',', $this->escape( array_values( $data ) ) );
		$table = $this->escapeField( $this->table );
		return "insert into $table ($keys) values ($values)";
	}
	public function setRollback( $flag = true ) {
		$this->rollback = $flag;
		return $this;
	}
	public function getRollback() {
		$this->rollback = $flag;
		return $this;
	}
	public function insert() {
		$query = $this->getInsertQuery();
		$this->db->query( $query );

		$this->{$this->primaryKey} = $q->getInsertId( $this->table . '_' . $this->primaryKey . '_seq' );
		if ( $this->rollback ) {
			$this->createInsertRollback( $this->{$this->primaryKey} );
		}
		return $q->rows();
	}
	public function update() {
		if ( ! $key = $this->{$this->primaryKey} ) {
			return false;
		}
		if ( $this->rollback ) {
			$this->createUpdateRollback( $key );
		}
		
		return $this->query->update( $this->getUpdateQuery() );
	}
	public function getUpdateQuery() {
		if ( ! $key = $this->{$this->primaryKey} ) {
			return false;
		}
		$key = $this->escape( $key );
		$set = $this->getSet( $this->data );
		return "update $this->table set $set where $this->primaryKey=$key";
	}
	public function rollback() {
		return $this->db->exec( $this->rollbackQuery );
	}
	//todo this is from UndoManager and not done refactoring.
	public function undo() {
		if ( $this->isEmpty() ) {
			throw new Exception( 'Undo list is empty.' );
		}
		$target = end( $this->data );
		if ( ! class_exists( $target->model ) ) {
			throw new Exception( $target->model . 'Class not exists!' );
		}
		foreach( $target->tasks as $task => $args ) {
			list( $model, $method ) = explode( '::', $args );
			$model = new $target->model;

			if ( $args instanceof MadData ) {
				$args = $args->getArray();
			} else {
				$args = array( $args );
			}
			$result = call_user_func_array( array( $model, $method ) , $args );

			if ( $result ) {
				unset( $target->tasks[$task] );
			}
		}
		array_pop( $this->data ); // remove from undo list
		return true;
	}
	public function createInsertRollback( $key ) {
		$this->rollbackQuery = "delete from $this->table where $this->primaryKey = $key";
		return true;
	}
	public function createDeleteRollback( $key ) {
		$modelName = getClass( $this );
		$model = new $modelName( $key );
		if ( ! $model->id ) {
			return false;
		}
		$this->rollbackQuery = $model->getInsertQuery();
		return true;
	}
	
	public function createUpdateRollback( $key ) {
		$modelName = getClass( $this );
		$model = new $modelName( $key );
		if ( ! $model->id ) {
			return false;
		}
		
		$this->rollbackQuery = $model->getUpdateQuery();
		return true;
	}
	public function update2() {
		$query = new MadQuery( $this->table );
		$set = $this->getSet( $this->data );
		$result = $query->update( $set )->where( "$this->primaryKey=$key" )->excute();
		return $result->rows();
	}
	public function delete( $key ) {
		if ( is_array ( $key ) ) {
			$key = implode(',', $key );
		}
		if ( $this->rollback ) {
			$this->createDeleteRollback( $key );
		}
		$key = $this->escape( $key );
		return $this->query->delete( "$this->primaryKey in ($key)" )->exec();
	}
	public function deleteWhere( $condition ) {
		return $this->db->exec( "delete from $this->table where $condition" );
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
	/*********************** getter/setter **********************/
	public final function setTable( $table ) {
		$this->table = $table;
	}
	public final function getTable() {
		return $this->table;
	}
	public final function setPrimaryKey( $primaryKey ) {
		$this->primaryKey = $primaryKey;
	}
	public final function getPrimaryKey() {
		return $this->primaryKey;
	}
	/********************* privates ***********************/
	protected function escape( $data ) {
		if ( is_array( $data ) ) {
			return $this->escapeAll( $data );
		}
		if ( ! preg_match( '/\)$/', $data ) ) {
		}
		if ( $this->server == 'mysql' ) {
			$data = mysql_real_escape_string( $data );
		} elseif ( $this->server == 'pgsql' ) {
			$data = pg_escape_string( $data );
		}
		if ( false === strpos($data , '::') ) {
			return "'$data'";
		}
		$temp = explode( '::', $data );
		$temp[0] = "'$temp[0]'";
		return implode( '::', $temp );
	}
	protected final function escapeAll( $data ) {
		foreach( $data as &$value ) {
			$value = $this->escape( $value );
		}
		return $data;
	}
	protected function escapeFields( $data ) {
		foreach( $data as &$value ) {
			$value = $this->escapeField( $value );
		}
		return $data;
	}
	protected function escapeField( $value ) {
		if ( $this->server == 'mysql' ) {
			return  "`$value`";
		} else if ( $this->server == 'pgsql' ) {
			return '"' . $value . '"';
		}
		return $value;
	}
	protected final function getSet( $data ) {
		$rv = array();
		foreach( $data as $key => $value ) {
			$value = $this->escape( $value );
			if ( $this->server == 'mysql' ) {
				$rv[] = "`$key`=$value";
			} else {
				$rv[] = "$key=$value";
			}
		}
		return implode( ', ', $rv );
	}
}

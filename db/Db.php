<?
class Db extends MadModel {
	private $db;
	private $attrs = array( 'autocommit', 'case', 'client_version', 'connection_status',
		'driver_name', 'errmode', 'oracle_nulls', 'persistent', 'prefetch',
		'server_info', 'server_version', 'timeout',);

	function getIndex() {
		return new MadData;
	}
	/*********************** config **********************/
	function getConfig( $target = '' ) {
		if ( empty( $target ) ) {
			return $this->config;
		}
		if ( empty( $this->config->$target ) ) {
			return new MadData;
		}
		return $this->config->$target;
	}
	function isEmpty() {
		return empty($this->db);
	}
	function fetch( $dsn='', $id='', $pw='' ) {
		if ( empty( $dsn ) ) {
			return $this;
		}
		$this->dsn = $dsn;
		$this->id = $id;
		$this->pw = $pw;

		$this->db = new MadDb( $dsn, $id, $pw );
		return $this;
	}
	function setDb( MadDb $db ) {
		$this->db = $db;
		return $this;
	}
	function attr( $name='', $setting='' ) {
		if ( empty( $name ) ) {
		}
		$name = MadString::create( $name )->underscore()->upper();
		$const = constant("PDO::ATTR_$name");
		return @$this->db->getAttribute( $const );
	}
	function attrs() {
		return $this->attrs;
	}
	function createConfig() {
		foreach( $this->db->explain( $this->table )->getData() as $row ) {
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
	// todo from ts
	function getDefineIndex() {
		$q = new ProjectQ("select * from information_schema.TABLES where TABLE_SCHEMA like '{$this->get->database}'");
		return $q->toArray();
	}
}

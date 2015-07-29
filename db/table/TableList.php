<?
class TableList extends MadListModel {
	protected $database;
	protected $table = 'information_schema.tables';
	private $table = '';

	function __construct( MadData $settings = null ) {
		if ( ! $settings->locale ) {
			$settings->locale = 'default';
		}
		if ( ! $settings->table_type ) {
			$settings->table_type = 'BASE TABLE';
		}

		parent::__construct( $settings );

		$this->query->where( "table_schema = 'pxprogram'" );
		$this->query->where( "table_type = '$settings->table_type'" );
	}
	function __construct( $table = '') {
		$this->table = $table;
		$this->data = new MadData;
	}
	function getIndex() {
		return new TableList($this);
	}
	function setColumnList() {
		$query = "show full columns from crm.`{$this->table}`";
		$q = new ProjectQ($query);
		$this->data = $q->toObject();
		return $this;
	}
	function setInfo() {
		$q = new ProjectQ("select * from information_schema.TABLES where TABLE_NAME like '$this->table'");
		$this->data->addData( $q->row() );
	}
	function setData() {
		if ( empty( $this->db ) ) {
			$q = new ProjectQ("show tables");
		} else {
			$q = new ProjectQ("show tables in $this->db");
		}
		$this->data = $q->col();
		return $this;
	}
	function __toString() {
		return $this->table;
	}
}

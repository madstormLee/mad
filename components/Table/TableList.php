<?
class TableList extends MadListModel {
	protected $database;
	protected $table = 'information_schema.tables';

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
	function setDatabase( $database ) {
		$this->db->setDatabase( $database );
		return $this;
	}
	function init() {
		parent::init();
	}
}

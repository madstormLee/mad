<?
class Activity extends MadJson {
	private $db = null;

	function setDb( DatabaseDiagram $db = null ) {
		if ( ! is_null( $db ) ) {
			$this->db = $db;
		}
		return $this;
	}
	function interpret() {
		$db = $this->db;

		if ( $db && $db->server == 'oracle' ) {
			foreach( $this->columns as $column ) {
				$column->name = strToUpper( camel2underscore( $column->name ) );
			}
			if ( $db->prefix ) {
				$this->name = strToUpper( $db->prefix . '_' . $this->name );
			}
		}
	}
	function getList() {
		$list = new DatabaseList($this);
		if ( $this->db ) {
			$list->setDb( $this->db );
		}
		return $list;
	}
}

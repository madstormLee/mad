<?
class Database extends MadDbModel {
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
}

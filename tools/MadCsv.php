<?
class MadCsv extends MadFile {
	protected $file = ''; 
	protected $delimiter = ','; 
	protected $columns = array(); 

	function __construct( $file = '', $columns=array() ) {
		$this->load( $file, $columns );
	}
	function setColumns( $columns = array() ) {
		$this->columns = $columns;
		return $this;
	}
	function load( $file = '', $columns = array() ) {
		if ( ! empty( $file ) ) {
			$this->setFile( $file );
		}
		if ( ! $this->isFile () ) {
			return $this;
		}
		if ( ! empty( $columns ) ) {
			$this->setColumns( $columns );
		}
		if (($handle = fopen( $this->file , "r")) === FALSE) {
			return $this;
		}

		while (($row = fgetcsv($handle, 1000, $this->delimiter)) !== FALSE) {
			if ( ! empty($this->columns) ) {
				$this->data[] = array_combine( $this->columns, $row );
			} else {
				$this->data[] = $row;
			}
		}
		fclose($handle);
		return $this;
	}
}

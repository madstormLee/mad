<?
class MadCsv extends MadData {
	protected $file = ''; 
	protected $delimiter = ','; 
	protected $columns = array(); 

	function __construct( $file = '', $columns=array() ) {
		$this->load( $file, $columns );
	}
	function isFile() {
		return is_file( $this->file );
	}
	function getFile() {
		return $this->file;
	}
	function setFile( $file ) {
		$this->file = $file;
		return $this;
	}
	function setColumns( $columns = array() ) {
		$this->columns = $columns;
		return $this;
	}
	function load( $file = '', $columns = array() ) {
		if ( ! empty( $file ) ) {
			$this->setFile( $file );
		}
		if ( ! empty( $columns ) ) {
			$this->setColumns( $columns );
		}
		if ( ! $this->isFile () ) {
			return $this;
		}

		if ( ! empty( $this->columns ) ) {
			return $this->loadDataAssoc();
		} else {
			return $this->loadDataArray();
		}
	}
	function loadDataAssoc() {
		if (($handle = fopen( $this->file , "r")) === FALSE) {
			return $this;
		}
		while (($row = fgetcsv($handle, 1000, $this->delimiter)) !== FALSE) {
			$assocRow = array();
			foreach( $this->columns as $key => $column ) {
				$assocRow[$column] = $row[$key];
			}
			$this->add( $assocRow );
		}
		fclose($handle);
		return $this;
	}
	function loadDataArray() {
		if (($handle = fopen( $this->file , "r")) !== FALSE) {
			while (($row = fgetcsv($handle, 1000, $this->delimiter)) !== FALSE) {
				$this->add( $row );
			}
			fclose($handle);
		}
		return $this;
	}
}

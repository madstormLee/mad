<?
class MadNavi extends Mad {
	private $data = array();

	function __construct( $data = '' ) {
		parent::__construct();
		$this->setData( $data );
	}
	function setData( $data ) {
		if ( isArray( $data ) ) {
			$this->data = $data;
		}
		return $this;
	}
	function add( $key, $value ) {
	}
	function get() {
		return $this->createSubDir( $this->data );
	}
	function createSubDir( $subDir ) {
		$rv = '';
		foreach( $subDir as $row ) {
			$rv .= "\n<dl>\n";
			if ( isset( $row['href'] ) ) {
				$rv .= "<dt><a href='{$row['href']}'>{$row['value']}</a></dt>\n";
			} else {
				$rv .= "<dt>{$row['value']}</dt>\n";
			}
			if ( isset( $row['subDir'] ) ) {
				$rv .= "\t<dd>".$this->createSubDir($row['subDir'])."</dd>\n";
			}
			$rv .= "</dl>\n";
		}
		return $rv;
	}
	function __set( $key, $value ) {
	}
	function __toString() {
		return $this->get();
	}
}

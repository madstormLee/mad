<?
class MadScheme {
	private static $force = false;
	private $file;
	private $db;
	private $scheme;
	private $tail = '';

	function __construct( $file = '' ) {
		$this->db = MadDb::create();
		$this->file = $file;
	}
	function setFile( $file ) {
		$this->file = $file;
		return $this;
	}
	function getFile() {
		return $this->file;
	}
	function setForce( $force = true ) {
		self::$force = ! ! $force;
		return $this;
	}
	function getForce() {
		return self::$force;
	}
	function setTail( $tail ) {
		$this->tail = $tail;
		return $this;
	}
	function setScheme( $scheme ) {
		$this->scheme = $scheme;
	}
	function installProc() {
		$q = $this->db->query( $this->scheme );
	}
	function install() {
		if ( self::$force == true ) {
			$scheme = substr( baseName( $this->file ), 0, -4 );
			$this->db->exec("drop table if exists $scheme");
		}

		$query = $this->getQuery();
		$queries = array_filter( explode( ';', $query ) );
		foreach( $queries as $query ) {
			$this->db->exec( $query );
		}
		return true;
	}
	function getQuery() {
		if ( ! is_file( $this->file ) ) {
			throw new Exception( 'file not found' );
		}
		$lines = file( $this->file );
		$rv = array();
		foreach( $lines as $line ) {
			if ( 0 === strpos( $line, '-' ) ) {
				continue;
			}
			if ( $commentStart = strpos( $line, '--' ) ) {
				$line = substr( $line, 0, $commentStart );
			}
			$rv[] = trim( $line );
		}
		$query = implode( ' ', $rv );
		if ( ! empty( $this->tail ) ) {
			$table = substr( baseName( $this->file ), 0, -4 );
			$toTable = $table . '_' . $this->tail;
			$query = str_replace( $table, $toTable, $query );
		}
		return $query;
	}
	function __toString() {
		return $this->getQuery();
	}
}

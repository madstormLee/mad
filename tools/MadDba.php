<?
class MadDba extends MadFileData {
	protected $file = ''; 

	private $modes = array(
			'plane',
			'matrix',
			);
	private $mode = 'plane';
	private $matrixData = null;

	function __construct( $file = '', $mode = 'plane' ) {
		$this->load( $file );
	}
	function load( $file = '' ) {
		if ( ! empty( $file ) ) {
			$this->setFile( $file );
		}
		if ( ! $this->isFile() ) {
			return $this;
		}
		$resource = dba_open( $this->file, 'rd', 'db4' );
		$data = array();

		$key = dba_firstkey( $resource );
		$value = trim( dba_fetch( $key, $resource ) );

		$data[trim($key)] = $value;

		while( $key = dba_nextkey( $resource ) ) {
			$value = trim( dba_fetch( $key, $resource ) );
			$data[trim( $key )] = $value;
		}
		dba_close( $resource );

		$this->setData( $data );
		return $this;
	}
	function getMatrix() {
		if ( ! $this->matrixData ) {
			$this->initMatrix();
		}
		return new MadData( $this->matrixData );
	}
	function setDataFromMatrix( $data ) {
		foreach( $data as $rowKey => $row ) {
			foreach( $row as $colKey => $column ) {
				$key = ( $rowKey + 1 ) . '.' . $colKey;
				$this->data[$key] = $column;
			}
		}
		return $this;
	}
	private function initMatrix() {
		$rv = array();
		foreach( $this->data as $key => &$value ) {
			if ( ! strpos(  $key, '.' ) ) {
				continue;
			}
			list( $row, $field ) = explode( '.', $key );
			if( ! isset( $rv[$row] ) ) {
				$rv[$row] = array();
			}
			$rv[$row][$field] = $value;
		}
		sort( $rv );
		$this->matrixData = new MadData( $rv );
	}
	function truncate() {
		$resource = dba_open( $this->file, 'n', 'db4' );
		dba_close( $resource );
		return $this;
	}
	function save( $file = '' ) {
		if ( empty( $file ) ) {
			$file = $this->file;
		}
		$resource = dba_open( $file, 'n', 'db4' );
		foreach( $this->data as $key => $value ) {
			dba_insert( $key . chr(0), $value . chr(0), $resource );
		}
		dba_close( $resource );
		return $this;
	}
	function saveAs( $file ) {
		return $this->save( $file );
	}
}

<?
class MadView extends MadFile {
	protected $file;
	protected $data = array();

	function __construct( $file = '' ) {
		$this->setFile( $file );
	}
	function getView() {
		return $this->getFile();
	}
	function setView( $file ) {
		return $this->setFile( $file );
	}
	function setData( $data = array() ) {
		$this->data = $data;
		return $this;
	}
	function addData( $data = array() ) {
		$this->data = array_merge( $this->data, $data );
		return $this;
	}
	function getContents() {
		if ( ! $this->isFile() ) {
			return '';
		}

		// and use assigned data 
		extract( $this->data );
		ob_start();
		include $this->getFile();
		$rv = ob_get_clean();

		if ( $this->componentPath ) {
			$rv = preg_replace('!(action|background|src|href)=(["\'])\./!i', "$1=$2{$this->componentPath}", $rv );
		}

		return $rv;
	}
	/********************** etc tools *********************/
	function save() {
		return file_put_contents( $this->file, $this->getContents() );
	}
	function saveAs( $file ) {
		$content = str_replace( "", '',$this );
		$dir = dirname( $file );
		if ( ! is_dir ( $dir ) ) {
			mkdir( $dir, 0777, true );
		}
		return file_put_contents( $file,  $content ) ? 1:0;
	}
	function saveContents( $contents ) {
		$dir = dirName( $this->getFile() );
		if ( ! is_dir( $dir ) ) {
			mkdir( $dir, 0777, true );
		}
		return file_put_contents( $this->getFile(), $contents ) ? 1:0;
	}
	function __set( $key, $value ) {
		$this->data[$key] = $value;
	}
	function __get( $key ) {
		if ( ! isset( $this->data[$key] ) ) {
			return '';
		}
		return  $this->data[$key];
	}
	function __isset( $key ) {
		return isset( $this->data[$key] );
	}
	function __unset( $key ) {
		unset( $this->data[$key] );
	}
	function __toString() {
		return $this->getContents();
	}
	function test() {
		(new MadDebug)->printR( $this->data );
	}
}

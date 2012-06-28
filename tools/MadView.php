<?
class MadView extends MadFile {
	const DEFAULT_EXTENSION = '.html';
	protected $data;

	function __construct( $file = '' ) {
		$this->data = new MadData;
		parent::__construct( $file );
	}
	function setView( $file ) {
		return $this->setFile( $file );
	}
	function setFile( $file ) {
		if ( 1 === count( explode('.', basename($file) ) ) ) {
			$file .= self::DEFAULT_EXTENSION;
		}
		return parent::setFile( $file );
	}
	function setData( $data = array() ) {
		$this->data->setData( $data );
		return $this;
	}
	function addData( $data = array() ) {
		$this->data->addData( $data );
		return $this;
	}
	function get() {
		if ( ! is_file( $this->getFile() ) ) {
			return '';
		}
		extract( $this->data->get() );
		$g = MadGlobal::getInstance();

		ob_start();
		include $this->getFile();
		return ob_get_clean();
	}
	/********************** etc tools *********************/
	function save() {
		return file_put_contents( $this->file, $this ) ? 1:0;
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
		$this->data->$key = $value;
	}
	function __get( $key ) {
		return $this->data->$key;
	}
	function __isset( $key ) {
		return isset( $this->data->$key );
	}
	function __unset( $key ) {
		unset( $this->data->$key );
	}
	function __toString() {
		return $this->get();
	}
	function test() {
		printR( $this->data );
	}
}

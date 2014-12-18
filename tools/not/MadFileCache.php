<?
class MadFileCache {
	private $time = 600;
	private $file;
	private $data;

	function __construct( $file, $time = 600 ) {
		$this->file = $file;
	}
	function setTime( $time ) {
		$this->time = $time;
		return $this;
	}
	function isCache() {
		if ( ! is_file( $this->file ) ) {
			return false;
		}
		if ( empty( $this->time ) ) {
			return true;
		}
		$fileTime = fileCTime($this->file);
		$age = time() - $fileTime;
		if ( $age > $this->time ) {
			return false;
		}
		return true;
	}
	function set( $data ) {
		$this->data = $data;
		return $this;
	}
	function get() {
		if ( ! is_file($this->file) ) {
			return false;
		}
		$rv = file_get_contents( $this->file );
		return unSerialize($rv);
	}
	function update() {
		return file_put_contents( $this->file, serialize($this->data) );
	}
}

<?
class MadUrlCamera {
	private $server;
	private $dir;
	private $url = 'thumbs/';

	function __construct( $server = '' ) {
		if ( ! empty( $server ) ) {
			$this->server = $server;
		}
	}
	function setDir( $dir ) {
		$this->dir = $dir;
		return $this;
	}
	function saveImage( $url ) {
		// not yet.
		return false;
		$url = urlEncode($this->get->url);
		if ( $image = file_get_contents("url=$url") ) {
			$file = "/thumbs/test.png";
			$result = file_put_contents($file, $image);
			var_dump( $result );
			return $this;
		}
	}
}

<?
// is needed charset(?), not implemented yet.
class MadJs {
	protected static $instance;
	protected $data = array();

	public static function getInstance(){
		if(! isset(self::$instance) ){
			self::$instance = new self;
		}
		return self::$instance;
	}
	function set( $value, $charset='' ) {
		return $this->add( $value, $charset='' );
	}
	function add( $value, $charset='' ) {
		if ( ! in_array( $value, $this->data ) ) {
			$this->data[] = $value;
		}
		return $this;
	}
  	function addExists( $fileName, $charset='' ) {
  		if ( is_file ( preg_replace('!\~/!i', PROJECT_ROOT, $fileName ) ) ) {
  			return $this->add( $fileName );
  		}
  		return $this;
  	}
	function addFirst( $value, $charset='' ) {
		if ( ! in_array( $value, $this->data ) ) {
			array_unshift( $this->data, $value );
		}
		return $this;
	}
	function addNext( $add, $target ) {
		foreach( $this->data as $key => $value ) {
			if ( false !== strpos( $value, $target ) ) {
				array_splice( $this->data, $key+1, 0, $add );
				break;
			}
		}
		return $this;
	}
	function remove($target) {
		foreach ( $this->data as $key => $value ) {
			if ( false !== strpos( $value, $target ) ) {
				unset($this->data[$key] );
			}
		}
		return $this;
	}
	function clear() {
		$this->data = array();
		return $this;
	}
	function __toString(){
		$rv = array();
		foreach ( $this->data as $src ){
			$rv[] = "<script type='text/javascript' src='$src'></script>\n";
		}
		return implode( "\n", $rv );
	}
	/******************** js utilities *******************/
	function alert($msg){
		$msg = _($msg);
		$msg = str_replace( "'", '"', $msg );
		$msg = str_replace( "\n", '\n', $msg );
		print "<script>alert('$msg');</script>";
		return $this;
	}
	function replace( $url ) {
		$url = $this->parseUrl( $url );
		print  "<script>location.replace('$url');</script>";
		die;
	}
	function move( $url ) {
		$url = $this->parseUrl( $url );
		print  "<script>location.href=('$url');</script>";
		die;
	}
	function back() {
		print "<script>history.back();</script>";
		die;
	}
	function replaceBack() {
		$server = MadParam::create('_SERVER');
		$referer = ckKey( 'HTTP_REFERER', $_SERVER );
		if ( !empty($referer) ) {
			$this->replace( $referer );
		}
		$this->back();
	}
	function closeWindow( $url = '' ) {
		print "<script>window.close();</script>";
		$this->replace( $url );
		die;
	}
	function moveOpener( $href ) {
		print "<script>opener.window.location.href='$href';</script>";
	}
	function flashin($file_name,$width='',$height=''){
		$file_name = $file_name . '.swf';
		$rv = "<script>Flash.print('$file_name',$width, $height)</script>";
		return $rv;
	}
	private function parseUrl( $url ) {
		$g = MadGlobals::getInstance();
		$rv = preg_replace('!\~/!i', "{$g->projectRoot}/", $url );
		$rv = preg_replace('!\./!i', "{$g->projectRoot}/{$g->periodPath}/", $rv );
		return $rv;
	}
	function test() {
		(new MadDebug)->printR($this->data);
		return $this;
	}
}

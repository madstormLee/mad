<?
class MadJs extends MadSingletonData {
	protected static $instance;

	public static function getInstance(){
		if(! isset(self::$instance) ){
			self::$instance = new self;
		}
		return self::$instance;
	}
	function set($value, $prefix='') {
		return $this->add( $value, $prefix );
	}
	function add( $value, $prefix = '' ) {
		if ( ! empty($prefix) ) $this->setPrefix( $prefix );
		$value = str_replace('.js','',$value);
		$value = $this->prefix.$value;
		if ( ! in_array( $value, $this->data ) ) {
			$this->data[] = $value;
		}
		return $this;
	}
	function addFirst( $value, $prefix = '' ) {
		if ( ! empty($prefix) ) $this->setPrefix( $prefix );
		$value = str_replace('.js','',$value);
		$value = $this->prefix.$value;
		if ( ! in_array( $value, $this->data ) ) {
			array_unshift( $this->data, $value );
		}
		return $this;
	}
	function remove($value) {
		foreach ( $this->data as $key => $v ) {
			if ( $v == $value ) {
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
		$rv = '';
		foreach ( $this->data as $value ){
			$rv .= "<script type='text/javascript' src='$value.js'></script>\n";
		}
		return $rv;
	}
	/******************** js utilities *******************/
	function alert($msg, $address='', $flag=''){
		echo "<script>alert('$msg');</script>";
		if ( !empty($address) ) {
			move($address,$flag);
		}
		return $this;
	}
	function replace( $page ) {
		$page = $this->pageParse( $page );
		echo  "<script>location.replace('$page');</script>";
		exit;
	}
	function move( $page ) {
		$page = $this->pageParse( $page );
		echo  "<script>location.href=('$page');</script>";
		exit;
	}
	function back() {
		echo "<script>history.back();</script>";
		exit;
	}
	function replaceBack() {
		$referer = ckKey( 'HTTP_REFERER', $_SERVER );
		if ( !empty($referer) ) {
			$this->replace( $referer );
		}
		$this->back();
	}
	private function pageParse( $page ) {
		$projectRoot = MadGlobal::getInstance()->urlRoot;
		return preg_replace('!^~/!', $projectRoot, $page );
	}
}

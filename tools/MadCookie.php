<?
// this is not done.
// and not even close.
class MadCookie extends MadAbstractData {
	protected $data = array();
	protected $domain = '';
	protected $time = 0;

	function __construct( $domain = '/' ) {
		$this->data = $_COOKIE;
		$this->setTimeString( '+1 month' );
		$this->setDomain( $domain );
	}
	function setDomain( $domain ) {
		if ( ! empty( $domain ) ) {
			$this->domain = $domain;
		}
		$this->domain = $domain;
		return $this;
	}
	function getDomain() {
		return $this->domain;
	}
	function unsetKeys( $data ) {
		foreach( $data as $key ) {
			unset( $this->$key );
		}
		return $this;
	}
	function setTime( $time ) {
		$this->time = $time;
	}
	function setTimeString( $timeString ) {
		$this->time = strToTime( $timeString );
	}
	function save() {
		foreach( $this->data as $key => $value ) {
			if ( isset( $this->data[$key] ) && $this->data[$key] == $_COOKIE[$key] ) {
				continue;
			}
			setcookie( $key, $value, $this->time, '/', $this->domain );
		}
	}
	function __unset( $key ) {
		if ( isset( $this->data[$key] ) ) {
			return setcookie( $key, '', strToTime('-1 hour'), '/', $this->domain );
		}
		unset( $this->data[$key] );
	}
	function __destruct() {
		$this->save();
	}
	function test() {
		print 'domain: ' . $this->domain;
		print BR;
		(new MadDebug)->printR( $this->data );
	}
}

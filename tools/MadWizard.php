<?
class MadWizard extends MadData {
	protected $sess;
	function __construct( $data = null ) {
		$this->setData( $data );
		$this->sess = new MadSession( get_class( $this ) );
		$this->sess->destroy();
		if ( ! $this->sess->currentKey ) {
			$this->setCurrentKey( key( $this->data ) );
		}
	}
	function setCurrentKey( $current ) {
		$this->sess->currentKey = $current;
	}
	function getCurrentKey() {
		return $this->sess->currentKey;
	}
	function getCurrent() {
		$key = $this->sess->currentKey;
		return $this->$key;
	}
	function next() {
	}
	function prev() {
	}
	function getNext() {
		$currentKey = $this->getCurrentKey();
		$stop = '';
		foreach( $this as $key => $unit ) {
			if ( $stop == 'now' ) {
				$nextKey = $key;
				return $unit;
				break;
			}
			if ( $key == $currentKey ) {
				$stop = 'now';
				continue;
			}
		}
		return current( $this->data );
	}
	function getNextHref() {
		return $this->getNext()->href;
	}
	function getNextLabel() {
		return $this->getNext()->label;
	}
}

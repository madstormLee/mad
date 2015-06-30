<?
class Autosave extends MadModel {
	protected $session;
	protected $interval = 60;

	function __construct( $id = '' ) {
		parent::__construct();
		$this->session = MadSession::getInstance();
		$this->formData = $this->session->autosave;
	}
	function setInterval( $interval ) {
		$interval = (integer) $interval;
		if ( $interval <= 0 ) {
			return $this;
		}
		$this->interval = $interval;
		return $this;
	}
	function getInterval() {
		return $this->interval;
	}
	function fetch( $id='' ) {
		if ( empty( $this->session->autosave ) ) {
			return '{}';
		}
		return $this->session->autosave;
	}
	function save() {
		$this->session->autosave = $this->formData;
		return $this->session->autosave;
	}
	function delete( $id='' ) {
		unset( $this->session->autosave );
	}
}

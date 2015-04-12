<?
class Calendar extends MadModel {
	protected $date;
	protected $time;
	protected $data = array();
	
	function __construct( $date = '' ){
		if ( ! empty( $date ) ) {
			$this->fetch( $date );
		}
	}
	function init() {
		foreach( range( 1, date('t', $this->time) ) as $key ) {
			$default = new MadData( array( 'event' => '' ) );
			$default->class = 'day';
			$this->data[$key] = $default;
		}
		if ( date('Y-m') == date('Y-m', $this->time ) ) {
			$this->data[(integer)date('d')]->class = 'day today';
		}
	}
	function getData() {
		return $this->data;
	}
	function setTime( $time ) {
		$this->time = $time;
		return $this;
	}
	function fetch( $date = '' ) {
	}
	function getDay1Time() {
		return strToTime( $this->getDay1() );
	}
	function getDay1() {
		return date('Y-m-01', $this->time);
	}
	function getWeek() {
		return date('w', $this->getDay1Time() );
	}
	function getPrepends() {
		$rv = array();
		$count = $this->getWeek();
		for( $i=0; $i < $count; ++$i ) {
			$rv[] = $i;
		}
		return $rv;
	}
	function getAppends() {
		$rv = array();
		$end = date('t', $this->time) + $this->getWeek();
		$count = (7 - $end % 7) % 7;
		for( $i=0; $i < $count; ++$i ) {
			$rv[] = $i + 1;
		}
		return $rv;
	}
	function getTime( $timeString='' ) {
		if ( empty($timeString) ) {
			return $this->time;
		}
		if ( $timeString == 'now' ) {
			return time();
		}
		return strToTime( "$timeString " . date('Y-m-d H:i:s', $this->time) );
	}
	function formatNow( $format='Y-m-d' ) {
		return $this->formatDate( $format, 'now' );
	}
	function formatDate($format='Y-m-d', $timeString='') {
		return date( $format, $this->getTime($timeString) );
	}
	function getIterator() {
		return new ArrayIterator( $this->data );
	}

	function getCaption() {
		return ucfirst(strftime("%B %Y", $this->time));
	}
	function getHeaders() {
		return array( 'S', 'M', 'T', 'W', 'T', 'F', 'S',);
	}
	function subtract( $date, $from='' ) {
		if ( empty($from) ) {
			$fromTime = $this->time;
		} else {
			$fromTime = strToTime( $from );
		}
		return $fromTime - strToTime($date);
	}
	function subtractDay( $date, $from = '' ) {
		return $this->subtract( $date, $from ) / 86400;
	}
	function addRotate( $startDate='2015-01-01' ) {
		$iters = array( '6시', '6시', '휴일', '22시', '22시', '22시', '휴일', '14시', '14시', '14시', '휴일', '6시');

		$day1 = $this->subtractDay( $startDate, $this->getDay1() );
		if ( $day1 < 0 ) {
			return false;
		}
		$count = count( $iters );
		foreach( $this->data as $day => &$row ) {
			$current = ( $day1 + $day - 1 ) % $count;
			$row->event = $iters[$current];
		}
	}
}

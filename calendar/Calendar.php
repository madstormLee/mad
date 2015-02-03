<?
class Calendar implements IteratorAggregate {
	protected $date;
	protected $time;
	protected $data = array();
	
	function __construct( $date = '' ){
		if ( ! empty( $date ) ) {
			$this->fetch( $date );
		}
	}
	function fetch( $date = '' ) {
		if ( empty( $date ) ) {
			$this->time = time();
		} else {
			$this->time = strToTime( $date );
		}
		$this->date = date('Y-m-d', $this->time );

		foreach( range( 1, date('t', $this->time) ) as $key ) {
			$default = new MadData( array( 'event' => '' ) );
			$default->class = 'day';
			$this->data[$key] = $default;
		}
		if ( date('Y-m') == date('Y-m', $this->time ) ) {
			$this->data[date('d')]->class = 'day today';
		}
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
	function formatNow( $format='Y-m-d' ) {
		return $this->formatDate( $format, 'now' );
	}
	function formatDate($format='Y-m-d', $timeString='') {
		if ( ! empty($timeString) ) {
			if ( $timeString == 'now' ) {
				$time = time();
			} else {
				$time = strToTime( "$timeString $this->date" );
			}
		} else {
			$time = $this->time;
		}
		return date( $format, $time );
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
		$start = 6;
		$iter = 1;

		$day = $this->subtractDay( $startDate, $this->getDay1() );

		if ( $day < 0 ) {
			return false;
		}
		if( $day != 0 ) {
			$rotate = floor(($day+$iter) / 4) % 3;
			$start = ( ($start+24) - ( $rotate * 8 ) ) % 24;
			$rest = $day % 4;
			$iter = ($iter + $rest) % 4;
		}

		foreach( $this->data as $day => &$row ) {
			if ( ++$iter > 3 ) {
				$iter = 0;
				$start = ( $start + 16 ) % 24;
				$row->event = "rest";

				continue;
			}
			$row->event = "start at : $start";
		}
	}
}

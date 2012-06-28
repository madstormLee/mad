<?
class MadDate {
	private $time;
	private $date;
	private $formatString = 'Y-m-d';
	public static $koreanDate = array('일', '월', '화', '수', '목', '금', '토', );

	function __construct( $date='' ) {
		if ( empty( $date ) ) {
			$date = date('Y-m-d H:i:s');
		}
		$this->date = $date;
		$this->time = strToTime( $date );
	}
	static function getToday() {
		return self::getNow();
	}
	static function getNow() {
		return new self;
	}
	function getNextWeek() {
		return new self( strToTime("$this->date +7day") );
	}
	function getPrevWeek() {
		return new self( strToTime("$this->date -7day") );
	}
	function setFormatString( $formatString ) {
		$this->formatString = $formatString;
	}
	function get( $formatString = '' ) {
		if ( ! empty( $formatString ) ) {
			$this->setFormatString( $formatString );
		}
		if ( false !== strPos( $this->formatString, 'kD' ) ) {
			$this->formatString = str_replace('kD', self::$koreanDate[date('w', $this->time )], $this->formatString);
		}
		if ( false !== strPos( $this->formatString, 'kl' ) ) {
			$this->formatString = str_replace('kl', self::$koreanDate[date('w', $this->time )] . '요일', $this->formatString);
		}
		return date( $this->this->formatString, $this->time );
	}
	function __toString() {
		return $this->get();
	}
}

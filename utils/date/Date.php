<?
class Date extends MadModel {
	protected $relPage = 'http://unicode.org/repos/cldr-tmp/trunk/diff/supplemental/territory_containment_un_m_49.html';
	protected $datetime = null;

	function __construct() {
		$this->datetime = new DateTime('now');
	}
	function getLocale() {
		return $this->datetime->getTimezone()->getName();
	}
	function getIndex() {
		$file = 'date/timezone.json';
		if ( is_file( $file ) ) {
			$data = new MadJson($file);
		} else {
			$data = new MadData;
			foreach( DateTimeZone::listIdentifiers() as $timezone ) {
				$data->add( new MadData( array( 'timezone' => $timezone ) ) );
			}
		}

		foreach( $data as &$row ) {
			$this->datetime->setTimeZone( new DateTimeZone($row->timezone) );
			$row->date = $this->datetime->format('H:i:s Y-m-d');
			$row->time = strToTime( $row->date );
		}
		$this->data = $data->getData();
		return $this->data;
	}
}

<?
class Date implements IteratorAggregate {
	private $data;
	private $relPage = 'http://unicode.org/repos/cldr-tmp/trunk/diff/supplemental/territory_containment_un_m_49.html';

	function __construct() {
		$this->data = new MadData;
		$l10n = MadL10N::getInstance();

		foreach( $l10n->getLocales() as $id => $row ) {
			date_default_timezone_set( $row->timezone );
			$this->data->$id = array(
					'label' => $row->label,
					'timezone' => $row->timezone,
					'date' => date("H:i:s Y-m-d "),
					'time' => time(),
					);
		}
		date_default_timezone_set( $l10n->timezone );
	}
	function getIterator() {
		return $this->data;
	}
	function __get( $key ) {
		return $this->data->$key;
	}
	function __toString() {
		$rv = "<dl class='date'>";
		foreach( $dates as $code => $date ) {
			$rv .= "<dt>$code</dt>";
			$rv .= "<dd>$date</dd>";
		}
		$rv .= "<dl>";
		return $rv;
	}
}

<?
class MadXTerm extends MadXUnit {
	private $sDate;
	private $eDate;
	function __construct( $sDate='', $eDate='' ) {
		parent::__construct();
		$this->sDate = new MadXDate;
		$this->sDate->id = 'sDate';
		$this->sDate->name = 'sDate';
		$this->sDate->value = $sDate;

		$this->eDate = new MadXDate;
		$this->eDate->id = 'eDate';
		$this->eDate->name = 'eDate';
		$this->eDate->value = $eDate;
	}
	function __toString() {
		$rv = "$this->sDate ~ $this->eDate";
		$rv .= "<a class='btnMadXTerm' href='#MadXTerm'>기간선택</a>
		<ul id='MadXTerm' style='display: none'>
			<li><a class='today' href='#today'>오늘</a></li>
			<li><a class='threeDays' href='#threeDays'>지난3일</a></li>
			<li><a class='week' href='#week'>지난7일</a></li>
			<li><a class='tenDays' href='#tenDays'>지난10일</a></li>
			<li><a class='month' href='#month'>지난30일</a></li>
			<li><a class='quarter' href='#quarter'>지난3개월</a></li>
			<li><a class='halfYear' href='#halfYear'>지난6개월</a></li>
			<li><a class='year' href='#year'>지난1년</a></li>
		</ul>
		";
		return $rv;
	}
}

<?
class CounterController extends MadController {
	function __construct() {
		parent::__construct();
		$this->counter = new MadCounter;
	}
	function indexAction() {
	}
	function listAction() {
		$currentMonYear = $this->sess->MadCounterCurrentMonYear;
		if ( empty($currentMonYear) ) {
			$currentMonYear = date('Ym');
		}
		$monYear = $this->get->monYear;
		if ( $monYear == 'prev' ) {
			$currentMonYear .= '01';
			$monYear = date('Ym',strtotime("$currentMonYear -1 month"));
		}
		if ( $monYear == 'next' ) {
			$currentMonYear .= '01';
			$monYear = date('Ym',strtotime("$currentMonYear +1 month"));
		}
		$_SESSION['MadCounterCurrentMonYear'] = $monYear;
		$tuple = array();
		$this->main->tuple = $this->counter->getMonthly($monYear);;
		$this->main->total = $this->counter->totalMonth;
	}
	function currentMonYearAction() {
		$currentMonYear = $this->sess->MadCounterCurrentMonYear;
		$currentMonYear .= '01';
		print $monYear = date('Y?? m??',strtotime($currentMonYear));
		die;
	}
}

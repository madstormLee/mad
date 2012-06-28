<?
class CounterController extends MadController {
	function __construct() {
		parent::__construct();
		if ( ! IS_AJAX ) {
			print 'Not Allowed';
			die;
		}
		$this->counter = new MadCounter;
	}
	function indexAction() {
	}
	function listAction() {
		$currentMonYear = ckSess('MadCounterCurrentMonYear');
		if ( empty($currentMonYear) ) {
			$currentMonYear = date('Ym');
		}
		$monYear = ckGet('monYear');
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
		$currentMonYear = ckSess('MadCounterCurrentMonYear');
		$currentMonYear .= '01';
		print $monYear = date('Y³â m¿ù',strtotime($currentMonYear));
		die;
	}
}

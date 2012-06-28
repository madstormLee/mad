<?
class MadCalendar extends MadAjaxController {
	function __construct(){
		parent::__construct();
	}
	function view(){
		$currentYear = empty($_POST['year']) ? date('Y') : $_POST['year'];
		$currentMonth = empty($_POST['month']) ? date('n') : $_POST['month'];

		$ts = mktime(0,0,0,$currentMonth,1,$currentYear);
		$first_day = date('w',$ts);
		$pre_days = '';
		for ( $i=0 ; $i < $first_day; $i++ ) {
			$pre_days .= '<td></td>';
		}
		$days = range(1,date('t', $ts));
		include $this->views . 'view.html';
	}
}

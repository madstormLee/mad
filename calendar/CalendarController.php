<?
class CalendarController extends MadController {
	function indexAction() {
		$get = new MadParams( '_GET' );
		$this->model->fetch( $get->yearMonth );
		if ( $get->user == 'seby' ) {
			$this->model->addRotate('2015-01-01');
		}
	}
}

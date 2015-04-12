<?
class CalendarController extends MadController {
	function indexAction() {
		$get = $this->params;
		$model = $this->model;

		if ( empty( $get->yearMonth ) ) {
			$time = time();
		} else {
			$time = strToTime( $get->yearMonth );
		}

		$model->setTime( $time );
		$model->init();
	}
}

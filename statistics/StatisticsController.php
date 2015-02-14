<?
class StatisticsController extends MadController {
	function indexAction() {
		$this->main->index = new MadJson('configs/Statistics/index.json');
	}
	function viewAction() {
		$get = $this->get;
		if ( ! $get->locale ) {
			$get->locale = 'jp';
		}
		if ( ! $get->year ) {
			$get->year = date('Y');
		}
		if ( ! $get->month ) {
			$get->month = date('n');
		}
		$args = array( "$get->year-$get->month", $get->locale );

		$this->js->addFirst('https://www.google.com/jsapi');
		// below is test data
		$stat = new Statistics( $this->get->url );
		$data = call_user_func_array( explode('::', $this->get->dataModel ), $args );
		$stat->setData( $data );

		// temporal
		$this->main->months = range( 1, 12 );
		$this->main->years = range( '2001', date('Y') );

		$this->main->param =  MadParams::except( array('year', 'month') );
		$this->main->stat = $stat;
	}
}

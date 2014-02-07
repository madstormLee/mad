<?
class ApiController extends MadController {
	function __construct() {
		parent::__construct();

		$server = MadParam::create('server');
		$get = $this->get;

		if ( ! $get->skey ) {
			$get->skey = '581a088dce02217809ef9164539f67bb8c1b32d7';
		}

		$whiteList = array(
				'127.0.0.1',
				'39.115.145.137',
				'121.101.95.135',
				'112.175.27.114',
				);

		$remote = $server->REMOTE_ADDR;
		$this->l10n->getInstance()->setCodeFromId( $this->get->locale );

		if ( $this->get->testWithGet == 'true' ) {
			unset( $this->get->testWithGet );
			$this->post = $this->get;
		}

		if ( ! in_array( $remote, $whiteList ) ) {
			throw new Exception( $this->error('need authentication') );
		}
	}
	function indexAction() {
		$data = $this->getList();
		if ( $callback = htmlspecialchars(strip_tags($this->get->callback)) ) {
			return $this->jsonpAction();
		}
		return $data->json();
	}
	function jsonpAction() {
		$get = $this->get;
		header("Content-Type: text/javascript; charset=utf-8");
		$data = $this->getList();

		if ( ! $callback = htmlspecialchars(strip_tags($get->callback)) ) {
			return '{}';
		}
		return $callback.'('.$data->json().')';
	}
	function resourceAction() {
		header("Content-Type: text/html;charset=utf-8");
		return printR( $this->getList()->getArray(), true );
	}
	// this will override.
	protected function getList() {
		return new MadData;
	}
	protected function error( $message ) {
		$rv = new MadData( array( 
			"result" => 0,
			"error" => 1,
			"message" => _( $message ),
		) );
		return $rv->json();
	}
	protected function success( $message, $result = 1 ) {
		$rv = new MadData( array( 
			"result" => $result,
			"error" => 0,
			"message" => _( $message ),
		) );
		return $rv->json();
	}
	protected function result( $result = 1, $data = null ) {
		$error = 0;
		if ( $result > 0 ) {
			$message = 'success';
		} else {
			$error = 1;
			$message = 'failure';
		}
		$rv = new MadData( array( 
			"result" => $result,
			"error" => $error,
			"message" => _( $message ),
			"data" => $data,
		) );
		return $rv->json();
	}
	function __call( $method, $args ) {
		return $this->indexAction();
	}
}

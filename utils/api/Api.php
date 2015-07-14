<?
class Api extends MadModel {
	function __construct() {
		$get = $this->get;

		if ( ! $get->skey ) {
			$get->skey = '581a088dce02217809ef9164539f67bb8c1b32d7';
		}

		$whiteList = array(
				'127.0.0.1',
				);

		$server = MadParams::create('server');
		$remote = 
		$this->l10n->getInstance()->setCodeFromId( $this->get->locale );

		if ( $this->get->testWithGet == 'true' ) {
			unset( $this->get->testWithGet );
			$this->post = $this->get;
		}

		if ( ! in_array( $server->REMOTE_ADDR, $whiteList ) ) {
			throw new Exception( $this->model->error('need authentication') );
		}
	}
	function getList() {
		return new MadData;
	}
	function error( $message ) {
		$rv = new MadData( array( 
			"result" => 0,
			"error" => 1,
			"message" => _( $message ),
		) );
		return $rv->json();
	}
	function success( $message, $result = 1 ) {
		$rv = new MadData( array( 
			"result" => $result,
			"error" => 0,
			"message" => _( $message ),
		) );
		return $rv->json();
	}
	function result( $result = 1, $data = null ) {
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
}

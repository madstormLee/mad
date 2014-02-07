<?
class MadException extends Exception {
	static function handler( Exception $e ) {
		$data = array(
				$e->getCode(),
				$e->getFile(),
				$e->getLine(),
				$e->getMessage(),
				);
		$contents = implode( "\t", $data ) . "\n" . $e->getTraceAsString() . "\n";

		@file_put_contents( 'logs/error.log', $contents, FILE_APPEND );
		return MadHeaders::replace('~/');
	}
}

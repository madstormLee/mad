<?
class MadMessageCode {
	private $code;
	function __construct( $code ) {
		$this->code = (string) $code;
	}
	function __toString() {
		return $this->code;
	}
}

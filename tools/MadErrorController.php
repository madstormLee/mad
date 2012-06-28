<?
class MadErrorController extends MadController {
	function __call( $method, $args ) {
		return "$this->controllerName controller does not exist.";
	}
}

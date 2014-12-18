<?
class MadControllerNotFoundException extends Exception {
	function __toString() {
		return "there is no $this->message file";
	}
}

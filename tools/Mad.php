<?
class Mad {
	function __construct() {
	}
	function getClassName() {
		return get_class($this);
	}
	function __toString() {
		return $this->getClassName();
	}
}

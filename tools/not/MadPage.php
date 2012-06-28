<?
class MadPage {
	private $domain;
	private $denyPage;
	private $pageLevel;

	function __construct( $domain ){
		$this->domain = $domain;
	}
	function limit( $condition ) {
	}
	function limitLevel($level) {
		$this->pageLevel = $level;
	}
	function limitGroup($group) {
		$this->group = $group;
		if ( ! in_array($user_group, $group) ) {
			$this->denied();
		}
	}
	function denied() {
		replace($this->deny_page);
		die;
	}
	function __toString(){
		return __class__;
	}
}


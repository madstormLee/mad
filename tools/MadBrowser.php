<?
class MadBrowser {
	private static $instance;
	private $agent = "PC";

	protected function __construct() {
		$server = MadParam::create('_SERVER');
		if ( ! $httpAgent = $server->HTTP_USER_AGENT ) {
			return null;
		}
		if ( preg_match( "/J-PHONE/i",  $httpAgent ) == TRUE ) {
			$this->agent = "vodafone";
		} else if ( preg_match( "/Vodafone/i", $httpAgent ) == TRUE ) {
			$this->agent = "vodafone";
		} else if ( preg_match( "/SoftBank/i", $httpAgent ) == TRUE )  {
			$this->agent = "vodafone";
		} else if ( preg_match( "/MOT/i", $httpAgent ) == TRUE ) {
			$this->agent = "vodafone";
		} else if ( preg_match( "/DoCoMo/i",  $httpAgent ) == TRUE ) {
			if(preg_match( "/ISIM/i", $httpAgent )) {
				$this->agent = "PC";
			} else {
				$this->agent = "DoCoMo";
			}
		} else if ( preg_match( "/UP.Browser/i", $httpAgent ) == TRUE ) {
			$this->agent = "au";
		} else {
			$this->agent = 'PC';
		}
	}
	public static function getInstance() {
		if ( ! self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}
	function isFeaturePhone() {
		if ( $this->agent != 'PC' ) {
			return true;
		}
		return false;
	}
	function getAgent() {
		return $this->agent;
	}
	function isAgent( $agent ) {
		return $this->agent == $agent;
	}
	// this check smartphone too.
	function isMobile() {
		$server = MadParam::create('_SERVER');
		$mobiles = array("iphone","lgtelecom","skt","mobile","samsung","nokia","blackberry","android","android","sony","phone"); 
		$checkCount = 0; 
		foreach( $mobiles as $mobile ) {
			if( preg_match("/$mobile/", strtolower($server->HTTP_USER_AGENT))) {
				return true;
			} 
		} 
		return false;
	}
	function isSmartPhone() {
		$SimpleMobile = new SimpleMobile();
		$smart_phone_agent = $SimpleMobile->_SimpleMobileClassify();
		$smart_phone_agent_array = array(
				"Emobile",
				"Ezweb",
				"Imode",
				"Other",
				"Softbank",
				"Willcom",
				"Apple1",
				"Apple2",
				"Google1",
				"Google2",
				"WindowsM1",
				"WindowsM2",
				);
		return in_array($smart_phone_agent, $smart_phone_agent_array);
	}
	function isPc() {
		return $this->isAgent( "PC" );
	}
}

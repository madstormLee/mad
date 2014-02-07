<?
class MadGeoIp {
	private static $instance = null;
	private $data = null;

	private function __construct() {
		$ip = $_SERVER["REMOTE_ADDR"];
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,'http://www.geoplugin.net/php.gp?ip='.$ip);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		$curl = curl_exec($ch);
		curl_close($ch);

		$this->data = @ unserialize($curl);
	}
	public static function getInstance() {
		if ( ! self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}
	function getLocale( $ip ) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,'http://www.geoplugin.net/php.gp?ip='.$ip);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		$curl = curl_exec($ch);
		curl_close($ch);
		return @ unserialize($curl);
	}
	function getData() {
		return $this->data;
	}
	function __get( $key ) {
		if ( isset( $this->data['geoplugin_' . $key] ) ) {
			return $this->data['geoplugin_' . $key];
		}
		return false;
	}
}

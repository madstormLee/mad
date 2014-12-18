<?
/* MadPageManager는 만들어지는 모든 페이지들의 설명이 들어있는 ini파일과 database를 관리한다.
   FrontController는 이걸로 페이지 기본 정보를 로드한다.
   MadNavigator는 이를 이용해서 '다음 페이지'나 '이전 페이지'를 설정한다.
   */
class MadPageManager {
	private $config;
	private $pageInfo;
	private $iniFile;

	function __construct() {
		$this->className = __class__;
		$config = $this->config = new MadRepository('config');
		$iniDir = "$config->iniDir$config->project/$config->controller/";
		$iniFile = "$config->action.ini";
		$this->iniManager = new MadIniManager( $iniDir . $iniFile );
		if ( $iniManager->isEmpty() ) {
			$this->makePageInfo();
		}
		$this->pageInfo = $this->iniManager->get($this->iniFile);
	}
	function makePageInfo() {
		if ( ! $this->iniManager->fromDb() ) {
			$this->makeDefaultPageInfo();
		}
	}
	private function makeDefaultPageInfo() {
		// naviInfo를 채우는데 주력.
		// controller에서 모든 Action이 들어가는 파일을 정렬 후 선후 관계를 만들어서 사용.
		// down은 비워두지만, up은 항상 존재할 것.
		$array = array(
				'pageInfo' => array(
					'title' => 'None',
					'author' => 'None',
					),
				'naviInfo' => array(
					'prev' => 'abc',
					'next' => '',
					'up' => '',
					'down' => '',
					),
				);
		$this->iniManager->set($array);
		$this->iniManager->save();
	}
	function getPageInfo() {
		return $this->iniManager->pageInfo;
	}
	function getNaviInfo() {
		return $this->iniManager->naviInfo;
	}
	function __get($key) {
		return $this->iniManager->$key;
	}
	function test() {
		$this->iniManager->test();
	}
}

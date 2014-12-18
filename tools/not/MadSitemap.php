<?
/*
   MadSitemap은 sitemap을 생성하고, 리턴한다.
   가장 주요한 것은 디렉토리를 보여주는 것이다.
   */
class MadSitemap {
	private $config;
	private $sitemap;

	function __construct() {
		$this->config = new MadRepository('config');
		$this->sitemap = $this->set();
	}
	// sitemap정보를 2D array로 반환.
	function __get($key) {
		return $this->sitemap[$key];
	}
	function set () {
		$tree = array();
		$controllers = $this->getControllers();
		foreach( $controllers as $controller ) {
			$tree[$controller] = $this->getActions($controller);
		}
		return $tree;
	}
	function get($controller='') {
		if ( empty($controller) ) {
			return $this->sitemap;
		}
		else {
			return $this->sitemap[$controller];
		}
	}
	function getControllers($project='') {
		if ( empty($project) ) {
			$project = $this->config->project;
		}
		$controllers = array();
		// 여기에서 파일이 있는지를 우선 테스트
		$d = dir('controllers');
		while (false !== ($entry = $d->read()) ) {
			if ( ereg('php$',$entry) ) {
				$controllers[] = substr($entry,0, strpos($entry,'.php'));
			}
		}
		$d->close();
		return $controllers;
	}
	function getActions($controller='') {
		if ( empty($controller) ) {
			$controller = $this->config->controller;
		}
		$classFile = 'controllers/' . $controller . '.php';
		if ( is_file( $classFile ) ) {
			include_once($classFile);
		}
		$actions = array();
		$class = $controller . 'Controller';
		if ( class_exists($class) ) {
			$methods = get_class_methods( $class );
			foreach($methods as $method) {
				if ( $pos = strpos($method, 'Action') ) {
					$actions[] = substr($method, 0, $pos);
				}
			}
		}
		return $actions;
	}
	function scanRoot($directory='contents',$floor=0){
		$dir = ROOT;
		$contents=$dr.'/'.$directory;
		$files=scandir($contents);
		foreach($files as $filename){
			if($filename=='.' or $filename=='..') continue;
			if(is_dir($contents.'/'.$filename)){
				$dirs[]=$directory.'/'.$filename;
			}
			$dirnames=explode('/',$directory);
			$dirname=array_pop($dirnames);
			mysql_query("insert into sitemap values ('','$dirname','$filename','$alias',0,$floor,1,200)");
			print "$floor $directory : <a href='/$directory/$filename'>$filename</a><br />";
		}
		$floor++;
		if(is_array($dirs)){
			foreach($dirs as $value){
				scan_contents($value,$floor);
			}
		}
	}
	function __toString() {
		return '';
	}
}

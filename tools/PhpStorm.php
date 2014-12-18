<?
/**
PhpStorm은 skeleton과 scaffolding, manual 등을 지원하는
site manager이다.
이 tool은 phpStorm app과는 다르지만,
서로 상호작용 한다.
*/
/**
assumptions
1:
MAD directory에는 PhpStorm이 필요한 모든 요소를 가지고 있다.
그러므로 PhpStorm은 Convention으로 적합하다.
2:
config 파일에 변경되지 않았다면,
projectRoot의 값은 . directory 이다.
3:
PhpStorm은 (storm이므로?) 어떤 것에도 의존하지 않는다.
위의 assumption을 제외하고는.
*/
class PhpStorm extends MadIni {
	function __construct( $file = '.phpStorm.ini' ) {
		if ( ! is_file( $file ) ) {
			$this->load( MAD . '.phpStorm.ini' );
			$this->save( $file );
		}
		parent::__construct( $file );

		if ( $this->config->skeleton == "auto" ) {
			PhpStormSkeleton::create( $this );
		}
	}
	public function scaffolding( $controllerName, $actionName ) {
		$scaffold = new PhpStormScaffold( $this );
		$scaffold->create( $controllerName );
	}
	private function addOpenedProject( $file ) {
		$opened = $this->sess->isLoad();
		$this->info->file = $file;
		array_unshift( $opened, $this->info );
		$opened = array_unique( $opened );
		$this->sess->opened = $opened;
		return $this;
	}
	function getDir( $dirName ) {
		if ( ! $this->isOpened() ) {
			throw new Exception('Project ini file not opened.');
		}
		if ( ! $this->dirs->$dirName ) {
			throw new Exception('Offset not found');
		}

		if ( $dirName == 'projectRoot' ) {
			return $this->projectDir;
		}
		return $this->projectDir . $this->dirs->$dirName;
	}
	function login( $pw ) {
		$encoding = $this->root->encoding;
		if ( $encoding($pw) === $this->root->password ) {
			return $this->sess->isLogin = true;
		}
		return false;
	}
}

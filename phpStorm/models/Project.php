<?
// project class를 PhpStorm과는 다르게 쓰기로 하자.
class Project extends MadSession {
	protected $projectDir = 'projects/';

	function __construct() {
		parent::__construct(__class__);
	}
	function open( $file ) {
		if ( is_file( $file ) ) {
			$this->phpStorm = new PhpStorm( $file );
		}
		return $this;
	}
	function isOpened() {
		return !!$this->phpStorm;
	}
	function close() {
		return $this->destroy();
	}
	function getRoot() {
		return dirName( $this->phpStorm->getFile() ) . '/';
	}
	function getConfigsDir() {
		return $this->getRoot() . 'json/configs/';
	}
	function save() {
		$file = $this->projectDir . $this->dirs->projectRoot . '.phpStorm.ini';
		$ini = new MadIni( $file );
		$ini->setData( $this->data );

		if ( ! $ini->save() ) {
			throw new Exception('save failure');
		}
		$this->load( $file );
		return $this;
	}
}

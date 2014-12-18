<?
class PhpStorm extends MadSingleton {
	private static $instance = null;
	protected $sess = null;

	protected function __construct() {
		parent::__construct();
		$this->sess = new MadSession('phpStorm');
		if ( ! $this->sess->opened ) {
			$this->sess->opened = array();
		}
		if ( ! $this->sess->ini ) {
			$this->sess->ini = new MadIni;
		}
	}
	public static function getInstance() {
		if ( ! self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}
	function open( $file ) {
		$this->sess->ini->load( $file );
		if ( $this->isOpened() ) {
			$this->addOpenedProject( $file );
			$this->projectDir = dirName( realPath( $this->getIniFile() ) ) . '/';
		}
		return $this;
	}
	function getOpenedProject() {
		return $this->sess->opened;
	}
	function getIniFile() {
		return $this->sess->ini->getFile();
	}
	private function addOpenedProject( $file ) {
		$opened = $this->sess->opened;
		$this->info->file = $file;
		array_unshift( $opened, $this->info );
		$opened = array_unique( $opened );
		$this->sess->opened = $opened;
		return $this;
	}
	function isOpened() {
		return ( $this->sess->ini->info );
	}
	function close() {
		$this->sess->destroy();
	}
	function getIni() {
		return $this->sess->ini;
	}
	function setIni( $ini ) {
		$this->sess->ini = $ini;
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
	function getFile( $fileName ) {
		if ( ! $this->isOpened() ) {
			throw new Exception('Project ini file not opened.');
		}
		if ( ! $this->files->$fileName ) {
			throw new Exception('Offset not found');
		}

		return $this->projectDir . $this->files->$fileName;
	}
	function login( $pw ) {
		$encoding = $this->root->encoding;
		if ( $encoding($pw) === $this->root->password ) {
			return $this->sess->isLogin = true;
		}
		return false;
	}
	function logout() {
		unset( $this->sess->isLogin );
	}
	function isRoot() {
		return $this->sess->isLogin;
	}
	function __get( $key ) {
		return $this->sess->ini->$key;
	}
	function __set( $key, $value ) {
		$this->sess->ini->$key = $value;
	}
	function test() {
		$this->sess->test();
	}
}

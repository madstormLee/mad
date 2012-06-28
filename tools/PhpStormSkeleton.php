<?
class PhpStormSkeleton {
	private $data;

	private function __construct( $phpStorm ) {
		$this->data = new MadData;
		$this->phpStorm = $phpStorm;
		// set default values;
		$this->targetDir = dirname( $phpStorm->getFile() );
		$this->projectName = basename( realpath( $this->targetDir ) );
		$this->skeletonDir = MAD . '.phpStorm/skeleton/';
		$this->now = date('Y-m-d h:i:s');
		$this->password = sha1( $this->projectName );
	}
	function __set( $key, $value ) {
		$this->data->$key = $value;
	}
	function __get( $key ) {
		return $this->data->$key;
	}
	static function create( PhpStorm $phpStorm ) {
		$skeleton = new self( $phpStorm );
		$skeleton->checkAppConfig();
	}
	private function checkAppConfig() {
		$configFile = $this->phpStorm->files->config;
		if ( ! is_file( $configFile ) ) {
			$this->createConfigFile();
		}
		$this->config = new MadIni( $configFile );
		$this->checkDirs();
		$this->checkFiles();
		$this->copySkeleton();
	}
	private function createConfigFile() {
		$view = new MadTemplate( $this->skeletonDir . 'configs/config.ini' );
		$view->setData( $this->data );
		return $view->saveAs('configs/config.ini');
	}
	private function checkDirs() {
		foreach( $this->config->dirs as $dir ) {
			if( ! is_dir( $dir ) ) {
				mkdir( $dir, 0777, true );
			}
		}
		return $this;
	}
	private function checkFiles() {
		foreach( $this->config->files as $file ) {
			if( ! is_file( $file ) ) {
				$view = new MadView( $this->skeletonDir . $file );
				$view->setData( $this->data );
				$view->saveAs( $file );
			}
		}
		return $this;
	}
	private function copySkeleton() {
		$dirs = new MadDir( $this->skeletonDir );
		foreach( $dirs as $dirName ) {
			$dir = new MadDir( $dirName );
			foreach( $dir as $file ) {
				if ( is_dir( $file ) ) {
					continue;
				}
				$targetDir = baseName( $dirName ) . '/';
				$target = $targetDir . basename($file);
				if ( ! is_dir( $targetDir ) ) {
					mkdir( $targetDir, 0777, true );
				}
				if ( ! is_file( $target ) ) {
					copy( $file, $target );
				}
			}
		}
	}
}

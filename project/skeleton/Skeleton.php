<?
class Skeleton {
	private $data = null;
	private $id = '';
	private $dir = '';

	function __construct() {
	}
	function fetch( $id ) {
		$this->id = $id;
	}
	function setDir( $dir ) {
		$this->dir = $dir;
	}
	function getIndex() {
		return new MadDir( 'project/skeleton/data' );
	}
	// todo: refactoring. from PhpStormSkeleton
	static function create( PhpStorm $phpStorm ) {
		$skeleton = new self( $phpStorm );
		$this->checkAppConfig();
	}
	private function checkAppConfig() {
		$this->projectName = basename( $this->targetDir );
		$this->skeletonDir = '.phpStorm/skeleton/';

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
		$view = new MadTemplate( $this->skeletonDir . 'config.json' );
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

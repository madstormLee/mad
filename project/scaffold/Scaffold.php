<?
class Scaffold extends MadJson {
	function __construct() {
		parent::__construct( 'json/components/Scaffold/default.json' );
		$this->project = ProjectSession::getInstance();
	}
	public function createFiles( $files ) {
		foreach( $files as $name => $file ) {
			if ( $file->isArray() ) {
				$this->createFiles( $file );
				continue;
			}

			$target = new MadFile( $this->project->root . $file );
			if ( $target->exists() ) {
				continue;
			}
			$contents = $this->getContents( $name );
			$target->save( $contents );
		}
	}
	// todo: refactoring. -- from PhpStormScaffold
	public function create( $name ) {
		$this->name = $name;
		$this->preset = $this->phpStorm->names->preset;

		if ( ! $this->preset ) {
			$this->preset = 'MadController';
		}

		$g = MadGlobal::getInstance();
		$dirs = $g->config->dirs;
		$controllerFile = $dirs->controllers . $name . 'Controller.php';
		if ( is_file( $controllerFile ) ) {
			return false;
		}
		$template = new MadTemplate( $this->phpStorm->dirs->scaffold . "controllers/BaseController.php");
		$template->setData( $this->data );
		$template->saveAs( $controllerFile );
	}
	function createDirs( $dirs ) {
		foreach( $dirs as $dir ) {
			$dir = new MadFile( $this->project->root . $dir );
			$dir->saveDir();
		}
		return $this;
	}
	private function getContents( $name ) {
		if ( ! $file = $this->$name ) {
			return '';
		}
		$contents = file_get_contents( $file );
		return trim( str_replace( '{id}', $this->id, $contents ) );
	}
}

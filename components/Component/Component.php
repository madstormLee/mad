<?
class Component extends MadJson {
	private $project = null;
	private $scaffold = null;

	function __construct( $file = '' ) {
		parent::__construct( $file );
		$this->project = ProjectSession::getInstance();
		$this->scaffold = new Scaffold;
	}
	function defaulting() {
		if ( ! $this->id ) {
			throw new Exception( 'ID does not exists.' );
		}
		$project = $this->project;

		$this->dirs = array(
			'css' => $project->getDir('css') . $this->id . '/',
			'js' => $project->getDir('js') . $this->id . '/',
			'views' => $project->getDir('views') . $this->id . '/',
			'component' => $project->getDir('components') . $this->id . '/',
			'controllers' => $project->getDir('controllers'),
			'models' => $project->getDir('models'),
		);

		$this->files = array(
			'views' => array(
				'index' => $this->dirs->views . "index.html",
				'write' => $this->dirs->views . "write.html",
				'view' => $this->dirs->views . "view.html",
			),
			'controller' => $this->dirs->controllers . $this->id . 'Controller.php',
			'listModel' => $this->dirs->models . $this->id . 'List.php',
			'model' => $this->dirs->models . $this->id . '.php',
		);
		return $this;
	}
	function delete() {
		$root = $this->project->root;
		$this->removeFile( $root . $this->files->controller );
		$this->removeFile( $root . $this->files->model );

		foreach( $this->files->views as $file ) {
			$this->removeFile( $root . $file ); 
		}
		foreach( $this->dirs as $dir ) {
			$this->delTree( $root . $dir );
		}
	}
	private function removeFile( $path ) {
		if ( is_file( $path ) ) {
			return unlink( $path );
		}
		return false;
	}
	private function delTree($dir) {
		$files = array_diff( scandir($dir), array('.','..') );
		foreach ( $files as $file ) {
			( is_dir("$dir/$file") ) ? $this->delTree("$dir/$file") : unlink("$dir/$file");
		}
		return rmdir($dir);
	} 
}

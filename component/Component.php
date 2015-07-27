<?
class Component extends MadModel {
	private $project = null;
	private $scaffold = null;
	private $views = array(
		'index', 'fileList', 'componentList',
	);

	function getView( $view = '' ) {
		if ( ! in_array( $view, $this->views ) ) {
			return 'index';
		}
		return $view;
	}
	function getIndex() {
		$rv = new MadData;
		$index = glob( "$this->id/*", GLOB_ONLYDIR );
		foreach( $index as $file ) {
			$rv->add( new self( $file ) );
		}
		return $rv;
	}
	function fetch( $id='' ) {
		$this->id = $id;
		$this->file = basename( $id );
		return $this;
	}
	function getFiles() {
		$rv = (new MadDir( $this->id ));
		return $rv->order();
	}
	function getInterfaces() {
		$rv = new MadData;
		$rv->addData( $this->getActions() );
		$rv->addData( $this->getViews() );
		return $rv;
	}
	function getViews() {
		$dir = new MadDir( $this->id, "*.html" );
		$rv = new MadData;
		foreach( $dir as $file ) {
			$rv->add( $file->getBasename('.html') );
		}
		return $rv;
	}
	function getActions() {
		$fileName = ucFirst(baseName( $this->id )) . 'Controller.php';
		$file = "$this->id/$fileName";
		if ( ! is_file( $file ) ) {
			return array();
		}
		$file = new MadFile( $file );
		$contents = $file->getContents();
		if( ! preg_match_all( '/(?<=function )[a-zA-Z0-9_]+(?=Action)/', $contents, $matches ) ) {
			return array();
		}
		return $matches[0];
	}
	function getScaffolds() {
		$rv = new MadData;
		foreach( glob('component/scaffold/data/*', GLOB_ONLYDIR) as $dir ) {
			$id = basename($dir);
			$row = new MadData( array(
				'id' => $id . 'Scaffold', 
				'value' => $id, 
				'label' => $id, 
			));
			$rv->add( $row );
		}
		return $rv;
	}
	function defaulting() {
		if ( ! $this->id ) {
			throw new Exception( 'ID does not exists.' );
		}
		$project = $this->project;

		return $this;
	}
	function delete( $id='' ) {
		$dir = new MadDir( $id );
		$project = $this->getProject();
		$root = $project->getDir() . '/' . $id;
		$this->removeFile( $root . $this->files->controller );
		$this->removeFile( $root . $this->files->model );

		foreach( $this->files->views as $file ) {
			$this->removeFile( $root . $file ); 
		}
		foreach( $this->dirs as $dir ) {
			$this->delTree( $root . $dir );
		}
	}
	private function delTree($dir) {
		$files = array_diff( scandir($dir), array('.','..') );
		foreach ( $files as $file ) {
			( is_dir("$dir/$file") ) ? $this->delTree("$dir/$file") : unlink("$dir/$file");
		}
		return rmdir($dir);
	} 
}

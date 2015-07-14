<?
class Component extends MadModel {
	private $project = null;
	private $scaffold = null;

	function getIndex( $path='' ) {
		$rv = new MadData;
		$index = glob( "$path/*", GLOB_ONLYDIR );
		foreach( $index as $file ) {
			$row = new MadData;
			$row->id = baseName($file);
			$row->files = (new MadDir( $file ))->order();
			$rv->$file = $row;
		}
		return $rv;
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

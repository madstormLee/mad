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

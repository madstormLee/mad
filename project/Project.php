<?
class Project extends MadJson {
	function __construct( $file = '' ) {
		parent::__construct( $file );
	}
	function getIndex() {
		$dir = new MadDir();
		// $dir->setPattern( '*/.madProject' );
		$dir->setFlag( GLOB_ONLYDIR );
		return $dir;

		$dirs = new MadFile( $this->dir );
		if ( ! $dirs->isDir() ) {
			return $this;
		}
		$dirs->filter('^\.');

		$data = array();
		foreach( $dirs as $dir ) {
			$file = $dir->getFile() . '/.madProject';
			if ( ! is_file( $file ) ) {
				$json = $this->getDefault( $file );
			} else {
				$json = new MadJson( $file );
			}
			$json->dir = $dir->getFile();
			$data[] = $json;
		}
		return $data;
	}
	private function getDefault( $file ) {
		$json = new MadJson( $file );
		$basename = baseName( dirName( $file ) );
		$json->id = $basename;
		$json->name = $basename;
		$json->label = $basename;
		$json->description = $basename;
		return $json;
	}
	function save() {
		if ( empty( $this->root ) ) {
			$this->root = "projects/$this->id";
		}
		$dir = new MadFile( $data->root );
		$dir->saveDir();
	}
	function registProject() {
		$projects = new MadJson( 'json/projects.json' );
		$projects->{$this->id} = $this->data;
		$projects->save();
	}



	// from ProjectDownloader
	private $target = array();
	private $ext = '.tar.gz';
	function findHead( $targetDir, $project ) {
		// MadDir can do that?
		$lastVersionName = '';
		$lastVersionFile = '';
		$dir = new MadDir($targetDir);

		$dir->setType( $project );
		foreach( $dir as $file ) {
			$currentName = strstr( baseName($file), $this->ext, true );
			if ( $lastVersionName < $currentName ) {
				$lastVersionName = $currentName;
			}
			$lastVersionFile = $file;
		}
		return $lastVersionFile;
	}
	function getTarget() {
		if ( ! $this->project ) {
			throw new Exception('need project');
		}
		if ( (! $this->version) || $this->version == 'head') {
			$target = $model->findHead( $targetDir, $this->project );
		} else {
			$fileName = $this->project . $this->version . $this->ext;
			$target = $targetDir . $fileName;
		}
		if ( ! is_file( $target ) ) {
			throw new Exception( $fileName . ' file not found.');
		}
	}
	function getContents() {
		return file_get_contents( $this->getTarget() );
	}
}

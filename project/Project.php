<?
class Project extends MadModel {
	protected $projectDir = 'project/data';

	function fetch( $id='' ) {
		if ( empty( $id ) ) {
			$file = '.madProject';
			$file = new MadJson('project/write.json');
			$this->data = $file->dic('value');
			$this->wDate = date('Y-m-d H:i:s');
			$this->uDate = date('Y-m-d H:i:s');
		} else {
			$file = "$id/.madProject";
			$this->data = new MadJson( $file );
		}
		return $this;
	}
	public static function getDatabase() {
		if ( isset( $_SESSION['project'] ) ) {
			return MadDb::create( "sqlite:{$_SESSION['project']}/.mad.db");
		}
		return MadDb::create('sqlite:.mad.db');
	}
	public static function session() {
		$session = MadSession::getInstance();
		if ( ! isset( $session->project ) ) {
			$session->project = '.';
		}
		return new self( $session->project );
	}
	function getIndex() {
		$rv = array();

		$dir = glob( 'project/data/*/.madProject' );
		foreach( $dir as $file ) {
			$row = new MadFile( $file );
			$row->date = $row->date();
			$row->id = $row->getDirname();
			$row->name = $row->getDirname();
			$row->href = $row->getDirname();
			$rv[] = $row;
		}
		return new MadData($rv);
	}
	function save( $data = '' ) {
		$dir = new MadDir($this->projectDir . "/$this->id");
		if ( ! $dir->isDir() ) {
			$dir->mkDir();
		}

		if ( empty( $this->wDate ) ) {
			$this->wDate = date('Y-m-d m:i:s');
		}
		$this->uDate = date('Y-m-d m:i:s');

		$json = new MadJson("$dir/.madProject");
		$json->setData( $this->data );

		if ( ! $json->save() ) {
			throw new Exception('save failure');
		}

		$this->createHtaccess( $dir );
		unlink( "$dir/mad" );
		if ( ! is_dir( "$dir/mad" ) ) {
			symlink( getcwd(), "$dir/mad" );
		}
		$this->createFront( $dir );
		$this->createIndex( $dir );
		$this->createConfig( $dir, $json );

		return $this;
	}
	function createFront( $dir ) {
		$file = "$dir/index.php";
		$contents = "<?php\ninclude 'mad/index.php';";
		return file_put_contents( $file, $contents );
	}
	function createIndex( $dir ) {
		$file = "$dir/index.html";
		$contents = "<h1>Index</h1>";
		return file_put_contents( $file, $contents );
	}
	function createConfig( $dir, $info ) {
		$info->year = date('Y', strToTime($info->wDate));
		$info->title = $info->id;
		$info->project = $info->id;
		$json = new MadJson( "$dir/config.json" );
		$json->info = $info;
		$json->instances = array(
			'db' => "MadDb::create('sqlite:data.db')",
			"debug" => "MadDebug::getInstance()",
			"session" => "MadSession::getInstance()",
			"layout" => "new MadView('mad/layout/default.html')",
		);
		$json->save();
	}
	function createHtaccess( $dir ) {
		$contents = "RewriteEngine On\n
			RewriteCond %{REQUEST_URI}  !(codeMirror) [NC]\n
			RewriteRule !\.(js|jpg|png|gif|css|swf)$ index.php [NC]";
		file_put_contents( "$dir/.htaccess", $contents );
	}
	/************* from mergeThis *************/
	function getIndexTemp() {
		$dirs = new MadDir();
		// $dirs->setPattern( '*/.madProject' );
		$dirs->setFlag( GLOB_ONLYDIR );

		return $dirs;

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
	function registProject() {
		$projects = new MadJson( 'json/projects.json' );
		$projects->{$this->id} = $this->data;
		$projects->save();
	}
	function getForms() {
		$json = new MadJson( 'project/write.json' );
		return new MadForm( $json );
	}

	// from ProjectDownloader
	private $target = array();
	private $ext = '.tar.gz';
	function findHead( $targetDir, $project ) {
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

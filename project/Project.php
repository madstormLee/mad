<?
class Project extends MadModel {
	protected $projectDir = '/projects/data';

	function __construct( $id = '' ) {
		parent::__construct( $id );
		if ( ! $this->isInstall() ) {
			$model = '/mad/project';
			MadJs::getInstance()->replace('/mad/component/model/install?model=' . $model);
		}
	}
	function isInstall() {
		$query = new MadQuery('Project');
		return $query->isTable();
	}
	function fetch( $id='' ) {
		if ( empty( $id ) ) {
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
	function getProjectDir() {
		if ( 0 === strpos( $this->projectDir, '/' ) ) {
			return $_SERVER['DOCUMENT_ROOT'] . $this->projectDir;
		}
		return $this->projectDir;
	}
	function getDb() {
		if ( isset( $_SESSION['project'] ) ) {
			return $_SESSION['project']->getDb();
		}
		$dir = $this->getProjectDir();
		
		return MadDb::create("sqlite:$dir/.mad.db");
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
}

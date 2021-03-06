<?
class Project extends MadModel {
	protected $projectDir = '/projects';

	function getIndex() {
		$dirs = new MadDir( $this->getProjectDir() );
		$dirs->flag( GLOB_ONLYDIR );

		$rv = new MadData;
		$rv->add( new self(MAD) );
		foreach( $dirs as $row ) {
			$row = new self( $row );
			$rv->add( $row );
		}
		return $rv;
	}
	function fetch( $id = '' ) {
		if ( $id instanceof MadFile ) {
			$file = $id;
		} else {
			$file = new MadFile( $id );
		}
		$router = MadRouter::getInstance();

		$this->id = $file->getFile();
		$this->title = $file->getBasename();
		$this->wDate = $file->date();
		$this->href = $router->path2Url( $file );

		return $this;
	}
	function getProjectDir() {
		if ( 0 === strpos( $this->projectDir, '/' ) ) {
			return $_SERVER['DOCUMENT_ROOT'] . $this->projectDir;
		}
		return $this->projectDir;
	}
	function getProjectDb() {
		if ( isset( $_SESSION['project'] ) ) {
			return $_SESSION['project']->getProjectDb();
		}
		$dir = $this->getProjectDir();
		
		return MadDb::create("sqlite:$dir/.mad.db");
	}
	public static function session() {
		$session = MadSession::getInstance();
		if ( ! isset( $session->project ) ) {
			$session->project = new self(MAD);
		}
		return $session->project;
	}
	function getSkeletons() {
		$rv = new MadData;

		$dirs = new MadDir( __DIR__ . '/skeleton/data' );
		foreach( $dirs as $dir ) {
			$rv[] = new MadData( array(
				'value' => $dir->getFile(),
				'label' => $dir->getBasename(),
			 	) );
		}
		return $rv;
	}
	function save() {
		$this->domain = "/projects/$this->title";
		$targetDir = new MadDir( $this->skeleton );

		$destDir = new MadDir($this->getProjectDir() . "/$this->title");
		$targetDir->copyFiles( $destDir );
		unset( $this->skeleton );
		parent::save();
	}
	function saveOld() {
		$dir = new MadDir($this->getProjectDir() . "/$this->id");
		print $dir;
		die;
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
			"layout" => "new MadView('layout.html')",
		);
		$json->save();
	}
	function createHtaccess( $dir ) {
		$contents = "RewriteEngine On\n
			RewriteCond %{REQUEST_URI}  !(codeMirror) [NC]\n
			RewriteRule !\.(js|jpg|png|gif|css|swf)$ index.php [NC]";
		file_put_contents( "$dir/.htaccess", $contents );
	}
}

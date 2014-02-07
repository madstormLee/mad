<?
class FileManual extends MadFile {
	protected $extension = 'html';
	protected $dir = 'data/FileManual';
	protected $contents = false;
	protected $suffix = '.manual.html';

	function __construct( $file = '' ) {
		parent::__construct( $file );
	}
	function getManualFile() {
		return $this->dir . '/' . $this->getFile() . $this->suffix;
	}
	// this is not right.
	function isManual() {
		return is_file( $this->getManualFile() );
	}
	function getActions() {
		$rv = array();
		$lines = explode("\n", $this->getContents());
		foreach( $lines as $line ) {
			if ( preg_match( '/function[ ]+([a-zA-Z0-9]+)Action/', $line, $matches ) ) {
				if ( isset( $matches[1] ) ) {
					$rv[] = $matches[1];
				}
			}
		}
		return $rv;
	}
	function getMethods() {
		$rv = array();
		$lines = explode("\n", $this->getContents());
		foreach( $lines as $line ) {
			if ( preg_match( '/function[ ]+([a-zA-Z0-9]+)/', $line, $matches ) ) {
				$rv[] = str_replace( '{', '', $line );
			}
		}
		return $rv;
	}
	function getClassName() {
		$contents = $this->getContent();
		if ( preg_match( '/class[ ]+([a-zA-Z0-9_]+)/', $this->getContents(), $matches ) ) {
			if ( isset( $matches[1] ) ) {
				return $matches[1];
			}
		}
		return 'NoName';
	}
	function getExtendsClass() {
		$contents = $this->getContent();
		if ( preg_match( '/extends[ ]+([a-zA-Z0-9_]+)/', $this->getContents(), $matches ) ) {
			if ( isset( $matches[1] ) ) {
				return $matches[1];
			}
		}
		return '';
	}
	function getControllerName() {
		$contents = $this->getContent();
		if ( preg_match( '/class[ ]+([a-zA-Z0-9]+)Controller/', $this->getContents(), $matches ) ) {
			if ( isset( $matches[1] ) ) {
				return $matches[1];
			}
		}
		return 'NoName';
	}
	function createController() {
		$view = new MadView('views/admin/FileManual/controller.html');
		$view->controllerName = $this->getControllerName();
		$view->actions = $this->getActions();
		return $view->__toString();;
	}
	function createClass() {
		$view = new MadView('views/admin/FileManual/class.html');
		$view->className = new MadString( $this->getClassName() );
		$view->extendsClass = $this->getExtendsClass();
		$view->methods = $this->getMethods();
		return $view->__toString();;
	}
	function createElse() {
		$view = new MadView('views/admin/FileManual/else.html');
		$view->fileName = $this->getFileName();
		if ( $this->isText() ) {
			$view->contents = htmlEntities( $this->getContents() );
		} else {
			$view->contents = '바이너리 파일 입니다.';
		}
		return $view->__toString();;
	}
	function create() {
		if ( $this->isController() ) {
			$contents = $this->createController();
		} else if ( $this->isClass() ) {
			$contents = $this->createClass();
		} else {
			$contents = $this->createElse();
		}
		$this->saveManual( $contents );
	}
	function saveManual( $contents ) {
		$file = $this->getManualFile(); 
		$dir = dirName( $file );
		if( ! is_dir( $dir ) ) {
			if ( ! mkdir ( $dir, 0777, true ) ) {
				throw new Exception( 'cannot make dir' . $dir );
			}
		}
		if ( ! file_put_contents( $file, $contents ) ) {
			throw new Exception( "cannot create Manual file" );
		}
	}
	// this is core in this class.
	function __toString() {
		if ( ! $this->isManual() ) {
			$this->create();
		}
		$view = new MadView( $this->getManualFile() );
		return $view->__toString();
	}
	function getContents() {
		if ( $this->contents === false ) {
			$this->contents = parent::getContents();
		}
		return $this->contents;
	}
	// tools
	function isClass() {
		return preg_match( '/class /', $this->getContents() );
	}
	function isModel() {
		return preg_match( '/extends[ ]+[a-zA-Z0-9]+Model/', $this->getContents() );
	}
	function isView() {
		return preg_match( '/html$/', $this->getFile() );
	}
	function isController() {
		return $this->isClass() && preg_match( '/class[ a-zA-Z]+Controller/', $this->getContents() );
	}
	public function getTree() {
		return new MadView( $this->dir . '/index.html' );
	}
	function rescan() {
		$dir = new MadFile( dirName($this->file) );
		$dir->filter( '^\.$|^\.\.$' );

		foreach( $dir as $file ) {
			$ctime = $file->getCtime();
			$name = $file->getBasename( '.' . $this->extension );

			if ( $file->isDir() ||
					$file->getExtension() != $this->extension ||
					( $this->$name && $this->$name->ctime == $ctime )
			   ) {
				continue;
			}
			$brief = ( new MadString( $file ))->stripTags()->cut( 100 );
			$title = $brief->cut( 20 );

			$this->$name = array(
					'title' => $title,
					'brief' => $brief,
					'file' => $file->getFile(),
					'ctime' => $ctime,
					);
		}
		return $this;
	}
	function test() {
		if ( ! $this->isFile() ) {
			$dir = dirName( $this->getFile() );
			if ( ! is_dir( $dir ) ) {
				@mkdir( $dir, 0755, true );
				@chmod( $dir, 0755 );
			}
			$this->rescan()->save();
		}
	}
}

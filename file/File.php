<?
class File extends MadDir {
	private $views = array('dirView','index','');
	private $view = 'index';
	// @override
	function setView( $view ) {
		if ( empty($view) ) {
			$this->view = 'index';
			return $this;
		}
		$this->view = $view;
		return $this;
	}
	function getView() {
		if ( $this->isFile() ) {
			return __DIR__ . "/view.html";
		}
		return __DIR__ . "/$this->view.html";
	}
	function setOption( $option ) {
		if ( $option == 'onlydir' ) {
			$this->setFlag( GLOB_ONLYDIR );
		} elseif ( $option == 'onlyfile' ) {
			$this->filter( 'is_file' );
		} else {
			$this->order('dirFirst');
		}
		return $this;
	}
	function setFile( $file='' ) {
		parent::setFile( $file );
		$router = MadRouter::getInstance();
		// $router = MadParams::create('route');
		// $router = MadGlobals::create('get');

		if ( ! $realpath = realpath($this->file) &&
			0 === strpos( $this->path, '/' ) &&
			file_exists( $router->document.$this->file ) ) {
				$this->file = $router->document.$this->file;
				$realpath = realpath( $this->file );
			}

		if ( 0 !== strpos( $realpath, realPath( $router->document ) ) ) {
			$this->file = '';
		}
		return $this;
	}
}

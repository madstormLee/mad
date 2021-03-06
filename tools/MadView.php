<?
class MadView extends MadFile {
	public static function index( MadIndex $index ) {
		$view = new self( MAD . 'component/view/index.html' );
		$view->index = $index;
		return $view;
	}
	// @override
	function getContents() {
		if ( ! $this->isFile() ) {
			return '';
		}

		extract( $this->data );
		$config = MadConfig::getInstance();
		ob_start();
		include $this->file;
		$rv = ob_get_clean();

		$rv = $this->urlAdjust( $rv );
		return $config->router->urlAdjust( $rv );
	}
	function urlAdjust( $value ) {
		$dir = dirName( $this->file );
		if ( ! preg_match( '!^/!', $dir ) ) {
			$dir = "~/$dir";
		} else {
			$router = MadRouter::getInstance();
			$dir = $router->url( $dir );
		}
		return preg_replace('!(action|background|src|href)=(["\'])\./!i', "$1=$2$dir/", $value );
	}
	// todo: refactory. from MadCacheView
	function updateCache( $contents ) {
		return $this->saveContents( $contents );
	}
	function clearCache() {
		if ( $this->cacheExists() ) {
			return unlink( $this->getFile() );
		}
		return false;
	}
	function isCache() {
		return $this->cacheExists();
	}
	function cacheExists() {
		return $this->isFile();
	}
	function __toString() {
		try {
			return $this->getContents();
		} catch ( Exception $e ) {
			return $e->getMessage();
		}
	}
}

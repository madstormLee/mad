<?
class MadView extends MadFile {
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
	function urlAdjust( $rv ) {
		$dir = dirName( $this->file );
		return preg_replace('!(action|background|src|href)=(["\'])\./!i', "$1=$2~/$dir/", $rv );
	}
	function __toString() {
		try {
			return $this->getContents();
		} catch ( Exception $e ) {
			return $e->getMessage();
		}
	}
}

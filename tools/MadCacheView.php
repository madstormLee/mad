<?
class MadCacheView extends MadView {
	function updateCache( $contents ) {
		return $this->saveContents( $contents );
	}
	function clearCache() {
		if ( $this->cacheExists() ) {
			return unlink( $this->getFile() );
		}
		return false;
	}
	function clear() {
		return $this->clearCache();
	}
	function isCache() {
		return $this->cacheExists();
	}
	function cacheExists() {
		return is_file( $this->getFile() );
	}
}

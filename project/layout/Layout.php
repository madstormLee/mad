<?
class Layout extends MadModel {
	private $dir = 'project/layout/data';

	function fetch( $id='' ) {
		$this->id = $id;
		$this->path = "$this->dir/$id";
		$this->title = $id;
		return $this;
	}
	function getIndex() {
		$dirs = new MadDir( $this->dir );
		$dirs->flag(GLOB_ONLYDIR);
		$rv = new MadData;
		foreach( $dirs as $dir ) {
			$row = new MadData;
			$row->id = $dir->getBasename();
			$row->title = $dir->getBasename();
			$rv->add( $row );
		}
		return $rv;
	}
}

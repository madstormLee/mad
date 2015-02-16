<?
class File extends MadDir {
	// @override
	function getIndex() {
		$rv = array();

		$dir = glob( '*', GLOB_ONLYDIR );
		foreach( $dir as $file ) {
			$row = new MadFile( $file );
			$row->date = $row->date();
			$row->name = $row->getBasename();
			$row->href = $row->getBasename();
			$rv[] = $row;
		}
		return $rv;
	}
}

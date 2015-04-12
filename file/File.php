<?
class File extends MadFile {
	// @override
	function getIndex() {
		$rv = new MadDir( $path, $pattern );
		return $rv;
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
	function getPwd() {
		return array();
	}
}

<?
class MadComponentList extends MadAbstractData {
	function __construct( $dir = PROJECT_ROOT ) {
		$file = new MadFile( $dir );
		$file->filter('^\.');
		foreach( $file as $row ) {
			$dir = $row->getFile();
			if ( ! is_dir( $dir ) ) {
				continue;
			}
			$unit = new MadData;
			$unit->id = lcFirst( $row->getBasename() );
			$unit->name = ucFirst($unit->id);
			$unit->component = ucFirst($unit->id);

			// component need index or controller
			if ( ! ( is_file( "$dir/index.php" ) || is_file( "$dir/{$unit->component}Controller.php" )  ) ) {
				continue;
			}
			$unit->files = $row->filter('^\.');
			$this->{$unit->id} = $unit;
		}
	}
}

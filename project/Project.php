<?
class Project extends MadJson {
	function __construct( $file ) {
		parent::__construct( $file );
	}
	function save() {
		if ( empty( $this->root ) ) {
			$this->root = "projects/$this->id";
		}
		$dir = new MadFile( $data->root );
		$dir->saveDir();
	}
	function registProject() {
		$projects = new MadJson( 'json/projects.json' );
		$projects->{$this->id} = $this->data;
		$projects->save();
	}
}

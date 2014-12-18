<?
class Skeleton {
	private $project = null;
	private $skeletonDir = '.skeleton';
	private $files = array(
			'.htaccess',
			'index.php',
			'json/configs.json',
			);

	function __construct( Project $project ) {
		$this->project = $project;
	}
	function create() {
		$projectDir = $this->project->getDir();
		foreach( $this->files as $file ) {
			$configs = new MadFile( "$this->skeletonDir/$file" );
			$configs->saveAs( "$projectDir/$file" );
		}
	}
}

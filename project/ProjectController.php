<?
class ProjectController extends MadController {
	function indexAction() {
	}
	function viewAction() {
		$model = new MadJson( $this->params->file );
		$this->main->model = $model;
	}
	function writeAction() {
		$get = $this->params;
		$projects = new MadJson( 'json/projects.json' );
		if ( ! $project = $projects->{$get->project} ) {
			$project = new MadData;
		}
		$this->main->model = $project;
	}
	function saveAction() {
		$post = $this->params;

		$project = new Project( $this->params );
		$project->setData( $post )->save();
		if ( $post->skeleton ) {
			$skeleton = new Skeleton( $project->getDir() );
			$skeleton->create();
		}
		$this->js->replace('./');
	}
	function openAction() {
		$project = new Project( $this->params->file );
		$project->root = dirName( $this->params->file );
		$project->configs = new MadJson( $project->root . '/configs/default.json' );
		$this->main->result = $this->projectLog->open( $project )->isOpen();
	}
	function closeAction() {
		$this->projectLog->close();
	}
	// this from madtools project
	function downloadAction() {
		$get = $this->params;
		$targetDir = "project/download/";
		$model = new ProjectDownloader;
		$model->setData( $get );

		MadHeaders::download( $get->project . $this->ext );
		print $model->getContents();
		die;
	}
}

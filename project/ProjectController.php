<?
class ProjectController extends MadController {
	function indexAction() {
		$this->main->list = new ProjectList();
	}
	function viewAction() {
		$model = new MadJson( $this->get->file );
		$this->main->model = $model;
	}
	function writeAction() {
		$get = $this->get;
		$projects = new MadJson( 'json/projects.json' );
		if ( ! $project = $projects->{$get->project} ) {
			$project = new MadData;
		}
		$this->main->model = $project;
	}
	function saveAction() {
		$post = $this->post;

		$project = new Project( $this->post );
		$project->setData( $post )->save();
		if ( $post->skeleton ) {
			$skeleton = new Skeleton( $project->getDir() );
			$skeleton->create();
		}
		$this->js->replace('./');
	}
	function openAction() {
		$project = new Project( $this->get->file );
		$project->root = dirName( $this->get->file );
		$project->configs = new MadJson( $project->root . '/configs/default.json' );
		$this->main->result = $this->projectLog->open( $project )->isOpen();
	}
	function closeAction() {
		$this->projectLog->close();
	}
	// this from madtools project
	function downloadAction() {
		$get = $this->get;
		$targetDir = "project/download/";
		$model = new ProjectDownloader;
		$model->setData( $get );

		MadHeaders::download( $get->project . $this->ext );
		print $model->getContents();
		die;
	}
}

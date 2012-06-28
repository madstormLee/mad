<?
class ProjectController extends Preset {
	function indexAction() {
		$this->js->replace("./list");
	}
	function importAction() {
		include MAD . 'controllers/FileBrowserController.php';
		$fb = new FileBrowserController;
		print $fb->indexAction();
		die;
		$fileBrowser = new MadAjaxWidget('/mad/fileBrowser?filter=.phpStorm.ini&style=TreeAndFileList');
		$this->main->fileBrowser = $fileBrowser;
		return $this->main;
	}
	function registAction() {
	}
	function listAction() {
		$list = new ProjectList;
		$this->main->list = $list;
		return $this->main;
	}
	function viewAction() {
		$get = $this->get;
		if ( ! $get->file ) {
			return new MadMessageCode('illegalAccess');
		}
		$this->main->model = new MadIni( $get->file );
		return $this->main;
	}
	function writeAction() {
		$this->main->json = new MadJson( 'json/forms/Project/write' );

		if ( $this->get->file && is_file( $this->get->file ) ) {
			$this->main->project = new Project( $this->get->file );
		} else if ( $this->project->isOpened() ) {
			$data = $this->project->getIni();
		} else {
			$form = new MadData;
		}
		return $this->main;
	}
	function openAction() {
		if ( ! $this->get->file ) {
			return false;
		}
		return $this->project->open( $this->get->file )->isOpened();
	}
	function closeAction() {
		$this->project->close();
		$this->js->replace('~/');
	}
	function saveAction() {
		$post = $this->post;
		if ( empty( $post->info->wDate ) ) {
			$post->info->wDate = date('Y-m-d m:i:s');
		}
		$post->info->uDate = date('Y-m-d m:i:s');

		$model = new MadIni( $post );
		$model->createDirs();
		$model->save();
		replace( "view?file=" . $model->getFile() );
	}
	function deleteAction() {
		$get = $this->get;
		if ( is_dir( $get->dir ) ) {
			rmDirAll( $get->dir );
		}
		replace( 'list' );
	}
	function registProjectAction() {
	}
}

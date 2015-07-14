<?
class GitController extends MadController {
	function indexAction() {
		$model = $this->model;
		$get = $this->params;
		// $get->dir = $_SERVER['DOCUMENT_ROOT'] . '/xp';
		if ( $get->dir ) {
			$model->setDir( $get->dir );
		}
	}
	function addAction() {
		$model = $this->model;
		if ( ! $result = $model->add( $this->params->file ) ) {
			throw new Exception( 'error' );
		}
		return "$result characters inserted.";
	}
	function infoAction() {
		$this->view = implode('<br />', $model->info() );
	}
	function diffAction() {
		$file = $this->params->file;
		$this->view = printR( `svn diff $file`, true );
	}
	function updateAction() {
		return $model = $this->model->update();
	}

	function addAllAction() {
		return `git add --all`;
	}
	function commitAllAction() {
		$message = $this->params->message;
		$command = "git commit -a -m '$message'";
		return `$command`;
	}
}

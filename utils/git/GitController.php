<?
class GitController extends MadController {
	function indexAction() {
		$model = $this->model;
		$get = $this->params;
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
		$comment = $this->params->comment;
		$command = "git commit -a -m '$comment'";
		return `$command`;
	}
}

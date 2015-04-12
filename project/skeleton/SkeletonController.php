<?
class SkeletonController extends MadController {
	function indexAction() {
		$this->config->session->project;
	}
	function writeAction() {
		$get = $this->params;
		$this->model->fetch( $get->id );
	}
	function skeletonAction() {
		$get = $this->params;

		$dir = new MadDir( $get->id );
		$dest = new MadDir( dirName($this->config->session->project) );
		return implode('<br />', $dir->copyR( $dest ) );
	}
}

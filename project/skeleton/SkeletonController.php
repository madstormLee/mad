<?
class SkeletonController extends MadController {
	function indexAction() {
	}
	function writeAction() {
		$get = $this->params;
		$this->model->fetch( $get->id );
	}
	function skeletonAction() {
		$get = $this->params;

		$dir = new MadDir( $get->id );
		$dest = new MadDir( dirName($this->project->id) );
		return 'not yet';
		return implode('<br />', $dir->copyR( $dest ) );
	}
}

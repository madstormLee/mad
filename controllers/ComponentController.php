<?
class ComponentController extends MadController {
	function indexAction() {
		$path = $this->get->path;
		if ( ! $path ) {
			$path = 'json/components';
		}
		$dir = new MadDir( $path );
		$this->main->dir = $dir;
		return $this->main;
	}
	function viewAction() {
		$model = new MadComponent( $this->get->file );
		$this->main->model = $model;
		return $this->main;
	}
	function writeAction() {
		return $this->main;
	}
	function save() {
	}
}

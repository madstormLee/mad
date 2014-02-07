<?
class FileBrowserController extends Preset {
	function indexAction() {
		if ( ! $this->get->dir || ! is_dir( $this->get->dir ) ) {
			$this->get->dir = ROOT;
		}
		$files = new MadDir( $this->get->dir );
		$files->setType( $this->filter );
		$this->main->files = $files;
		return $this->main;
	}
	function listAction() {
		return $this->get->path;
	}
	function getListAction() {
		$this->main->files = new MadDir( $this->get->path );
		return $this->main;
	}
}

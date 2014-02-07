<?
class SchemeController extends MadController {
	function indexAction() {
		$list = new SchemeList(  );
		$this->main->list = $list;
	}
	function installAction() {
		$scheme = new MadScheme( $this->get->file );
		$scheme->install();
		$this->js->replaceBack();
	}
}

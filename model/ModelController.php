<?
class ModelController extends MadController {
	function indexAction() {
		$list = new ModelList( $this->projectLog->root . $this->projectLog->configs->dirs->controllers );

		$this->main->list = $list;
	}
}

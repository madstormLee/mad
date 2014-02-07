<?
class LocaleController extends MadController {
	function indexAction() {
		$this->main->list = $this->l10n->getLocales();
	}
	function selectAction() {
		$this->l10n->setCode( $this->get->code );
		$this->js->replaceBack();
	}
	function writeAction() {
		$this->main->model = new Locale( $this->get->id );
	}
	function viewAction() {
		$this->main->model = new Locale( $this->get->id );
	}
	function insertAction() {
		$model = new Locale;
		$model->setData( $this->post )->insert();
		$this->js->replace('./');
	}
	function updateAction() {
		$model = new Locale;
		$model->setData( $this->post )->update();
		$this->js->replace('./');
	}
	function deleteAction() {
		$model = new Locale;
		$model->delete( $this->post->id );
		$this->js->replace('./');
	}
}

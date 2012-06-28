<?
class Preset extends MadController {
	protected function init() {
		$this->log = MadLog::getInstance();
		$this->js = MadJs::getInstance();
		if ( ! $this->log->isRoot() && 
			$this->controllerName !== 'Log' &&
			$this->actionName !== 'root' ) {
			$this->js->replace('/mad/log/root');
		}
		$this->get = new MadData( sqlin($_GET) );
		$this->post = new MadData( sqlin($_POST) );

		$this->main = new MadView("views/$this->controllerName/$this->actionName");
		$this->project = new Project;
	}
	protected function initGet() {
		$this->phpStorm = new PhpStorm;
		$this->phpStormWidget = new PhpStormWidget( $this->phpStorm );
		$this->sitemap = new MadSitemap;

		$this->style = MadCss::getInstance()
		->add('~/css/base')
		->add("~/css/$this->controllerName/$this->actionName");

		$this->js->add('/mad/js/prototype')
		->add('/mad/js/tools')
		->add('~/js/base')
		->add("~/js/$this->controllerName/$this->actionName");

		$this->setLayout( new MadView('views/layouts/simple') );

		$this->style = MadCss::getInstance();
		$this->js = MadJs::getInstance();
		$this->title = 'PhpStorm';

		$this->header = new MadView('views/header');
		$this->footer = new MadView('views/footer');

		$this->left = new MadView('views/left');
		$this->right = new Right;
	}
	protected function initAjax() {
	}
}

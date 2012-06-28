<?
class Preset extends MadController {
	protected function init() {
		// $this->log = MadLog::getInstance();
		// varDump( $this->log );
		if ( ! $this->log->isRoot() && 
			$this->controllerName !== 'Log' &&
			$this->actionName !== 'root' ) {
			$this->js->replace('/mad/log/root');
		}
		// $this->main = new MadView("views/$this->controllerName/$this->actionName");
	}
	protected function initGet() {
		// $phpStorm = new PhpStorm;
		// $this->phpStormWidget = new PhpStormWidget( $phpStorm );
		// $this->phpStormMenu = new PhpStormMenu( $phpStorm );
		// $this->sitemap = new MadSitemap;

		// setting basic assets
		// $this->style = MadCss::getInstance();

		// $this->style->add('~/css/base');
		// $this->style->add("~/css/$this->controllerName/$this->actionName");
		// $this->js->add("~/js/$this->controllerName/$this->actionName");

		// use default layout
		// $this->setLayout( new MadView('views/layouts/preset') );

		// $this->left = new MadView('views/left');
		// $this->header = new MadView('views/header');
		// $this->footer = new MadView('views/footer');

		// $this->header->phpStormMenu = new PhpStormMenu;
	}
	protected function initAjax() {
	}
}

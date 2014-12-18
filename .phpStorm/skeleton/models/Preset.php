<?
class Preset extends MadController {
	protected function init() {
		$phpStorm = new PhpStorm;
		$this->phpStormWidget = new PhpStormWidget($phpStorm);
		// create default variables in global
		$this->get = new MadData( sqlin($_GET) );
		$this->post = new MadData( sqlin($_POST) );
		$this->sitemap = new MadSitemap;

		// generally post is empty set means there is no processings
		if ( ! $this->post->isEmpty() ) {
			return false;
		}

		// setting basic assets
		$this->style = MadCss::getInstance();
		$this->js = MadJs::getInstance();

		$this->style->add('~/css/base');
		$this->style->add("~/css/$this->controllerName/$this->actionName");
		$this->js->add("~/js/$this->controllerName/$this->actionName");

		// use default layout
		$layout = $this->setLayout( new MadView('layouts/proto') );
		$layout->useGlobals();

		$this->left = new MadView('views/left');
		$this->header = new MadView('views/header');
		$this->footer = new MadView('views/footer');
		$this->main = new MadView("views/$this->controllerName/$this->actionName");
	}
	protected function initAjax() {
		// $this->setLayout( new BasicLayout );
	}
}

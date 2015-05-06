<?
class SitemapController extends MadController {
	function indexAction() {
		$index = new MadJson( 'sitemap.json' );
		$this->view->index = $index;
	}
	function treeAction() {
		$this->js->addFirst('/mad/js/prototype');
		$this->main->sitemap = $this->sitemap;

		$mvcManager = new MadView('views/MvcManager/widget');
		$mvcManager->controllers = new Controllers;
		$this->main->mvcManager = $mvcManager;

		return $this->main;
	}
	function viewAction() {
		$current = $this->sitemap->getPath( $this->get->href );
		$this->main->current = $current;
		return $this->main;
	}
	function writeAction() {
		$this->js->addFirst('/mad/js/prototype');
		$sitemap = $this->sitemap;
		$current = $sitemap->getPath( $this->get->href );

		$mvcManager = new MadView('views/MvcManager/widget');
		$mvcManager->controllers = new Controllers;

		$this->main->current = $current;
		$this->main->mvcManager = $mvcManager;
		return $this->main;
	}
	function addSubAction() {
		$sitemap = $this->sitemap;
		$sitemap->addSub( $this->get->current, $this->post );
		$sitemap->save();
		$this->js->replace('back');
	}
	function saveAction() {
		$target = 'sitemap.json';
		$sitemap = new Sitemap( $target );
		$sitemap->setFromDl( $this->post->content );
		$sitemap->save();
	}
	function deleteAction() {
		$this->sitemap->removePath( $this->get->href )
			->save();
		$this->js->replace('back');
	}
}

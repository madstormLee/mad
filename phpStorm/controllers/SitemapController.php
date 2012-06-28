<?
class SitemapController extends Preset {
	function indexAction() {
		$this->main->sitemap = $this->sitemap;
		return $this->main;
	}
	function widgetTreeAction() {
		return $this->treeAction();
	}
	function treeAction() {
		$sitemap = new MadSitemap( $this->project->getRoot() . 'json/sitemap' );
		$this->main->sitemap = $sitemap;

		return $this->main;
	}
	function viewAction() {
		$current = $this->sitemap->getPath( $this->get->href );
		$this->main->current = $current;
		return $this->main;
	}
	// not use.
	function listAction() {
		$this->model->load( $this->phpStorm->getFile( 'siteMap' ) );
		
		$this->main->info = $this->phpStorm->info;
		$this->main->sitemap = new MadNavi( $this->model->unsited );
		return $this->main;
	}
	function writeAction() {
	}
	function writeSubAction() {
		// js는 use로 framework을 사용하자.
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
		replace('back');
	}
	function removeAction() {
		$this->sitemap->removePath( $this->get->href )
			->save();
		replace('back');
	}
	function saveAction() {
		$this->sitemap->saveContents( $this->post->content );
		replace('back');
	}
}

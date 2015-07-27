<?
class SitemapController extends MadController {
	function indexAction() {
	}
	function orderAction() {
	}
	function reorderAction() {
		$text = trim($this->params->contents);
		$text = "<dd>$text</dd>";

		$json = new MadJson('sitemap.json');
		$json->setFromDl( $text );
		return $json->save();
	}
	function treeAction() {
		$this->model->setDir( $this->project->id );
	}
	function viewAction() {
		$current = $this->sitemap->getPath( $this->get->href );
		$this->main->current = $current;
		return $this->main;
	}
	function writeAction() {
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

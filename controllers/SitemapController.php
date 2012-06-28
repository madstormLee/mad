<?
class SitemapController extends Preset {
	function indexAction() {
		$this->main->sitemap = $this->sitemap;
		return $this->main;
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
	function listAction() {
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
	function getActionsAction() {
		$controllerName = $this->get->controller . 'Controller';
		include_once "controllers/$controllerName.php";
		$controller = new $controllerName;
		$actions = $controller->getActions();
		$rv = '<ul>';
		foreach( $actions as $action ) {
			$rv .= "<li><a href='#action'>$action</a></li>";
		}
		$rv .= '</ul>';
		return $rv;
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

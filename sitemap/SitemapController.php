<?
class SitemapController extends MadController {
	function indexOldAction() {
		$this->layout->setView('views/layouts/write.html');
		$this->js->addNext("http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js", 'jquery');
		$this->right = new MadView( 'views/Sitemap/right.html' );

		$target = $this->projectLog->root . $this->projectLog->configs->dirs->configs . 'sitemap.json';
		$sitemap = new Sitemap( $target );
		$this->main->sitemap = $sitemap;

	}
	function indexAction() {
	}
	function writeAction() {
		$get = $this->params;
		$sitemap = $this->config->sitemap;
		if ( $get->path ) {
			$formData = $sitemap->fetch( $get->path );
		} else {
			$formData = new MadData;
		}
		$this->view->formData = $formData;
	}
	function deleteAction() {
		$get = $this->params;
		$sitemap = $this->config->sitemap;
		return $sitemap->delete( $get->path );
	}
	function saveAction() {
		$post = $this->params;
		$sitemap = $this->config->sitemap;
		$target = $sitemap->fetch( $post->path );
		foreach( $post as $key => $value ) {
			$target->$key = $value;
		}
		return $sitemap->save();
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
		$this->js->replace('back');
	}
	function removeAction() {
		$this->sitemap->removePath( $this->get->href )
			->save();
		$this->js->replace('back');
	}
}

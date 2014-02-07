<?
// fix permition problems
class ComponentController extends MadController {
	function indexAction() {
		$this->main->list = new ComponentList($this->get);
	}
	function listAction() {
		$list = new ComponentList( $this->get );
		foreach( $list as $row ) {
			$file = $this->projectLog->root . $row->files->controller;
			if ( ! is_file( $file ) ) {
				continue;
			}
			include_once $file;

			$controllerName = baseName( $row->files->controller, '.php' );
			try {
				$controller = new $controllerName;
			} catch ( Exception $e ) {
				continue;
			}
			$row->interfaces = $controller->getActions();
		}
		$this->main->list = $list;
		return $this->main;
	}
	function writeAction() {
		$get = $this->get;
		$get->id = ucFirst( $get->id );
		$this->right = new MadView( 'views/Component/right.html' );
		if ( $get->id ) {
			$file = $this->projectLog->getAbsDir('components') . "$get->id/component.json";
		}
		$this->main->model = new Component( $this->get->file );
	}
	function saveAction() {
		$post = $this->post;
		$post->id = ucFirst( $post->id );
		$file = $this->projectLog->getAbsDir('components') . "$post->id/component.json";

		$model = new Component( $file );
		$model->id = $post->id;

		if ( ! $model->isFile() ) {
			$model->defaulting();
		}
		$model->save();

		if ( $post->scaffold == 1 ) {
			$scaffold = new Scaffold;
			$scaffold->createDirs( $model->dirs );
			$scaffold->createFiles( $model->files );
		} 

		$this->js->replace( './' );
	}
	function deleteAction() {
		$model = new Component( $this->get->id );
		throw new Exception('dont do that');
		// $model->delete();
	}
}

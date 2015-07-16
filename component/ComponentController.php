<?
class ComponentController extends MadController {
	function indexAction() {
		$get = $this->params;
		if ( ! $get->path ) {
			if ( isset($this->session->project) ) {
				$get->path = $this->session->project;
			} else {
				$get->path = '.';
			}
		}

		$this->view->index = $this->model->getIndex( $get->path );
	}
	function treeAction() {
	}
	function fileListAction() {
		$get = $this->params;
		if ( ! $get->path ) {
			if ( isset($this->session->project) ) {
				$get->path = $this->session->project;
			} else {
				$get->path = '.';
			}
		}

		$this->view->index = $this->model->getIndex( $get->path );
	}
	function writeAction() {
		$get = $this->params;
		$get->id = ucFirst( $get->id );
		$this->right = new MadView( 'views/Component/right.html' );
		if ( $get->id ) {
			$file = $this->projectLog->getAbsDir('components') . "$get->id/component.json";
		}
		$this->view->model = new Component( $this->params->file );
	}
	function saveAction() {
		$post = $this->params;

		if ( isset($this->session->project) ) {
			$post->path = $this->session->project;
		} else {
			$post->path = '.';
		}

		$dir = new MadDir("$post->path/$post->name");
		if ( $dir->exists() ) {
			// throw new Exception( $dir . ' is already exists.');
		}
		if ( ! $dir->mkdir() ) {
			throw new Exception( $dir . ' cannot be created.');
		}
		if ( ! $post->scaffold ) {
			$post->scaffold = 'default';
		}
		// copy all dir.
		$files = new MadDir("component/scaffold/data/$post->scaffold");
		$rv = 0;
		foreach( $files as $file ) {
			$ext = $file->getExtension();
			$file = new MadFile( $file );
			$name = ucFirst($post->name);
			$data = array(
				'name' => $name,
			);
			$contents = $file->template( $data );
			$destFile = "$post->path/$post->name/" . str_replace('Model', $name, $file->getBasename() );
			$file->setFile( $destFile );
			$rv += !! $file->saveContents( $contents );
		}
		return $rv;
	}
	function saveTempAction() {
		$post = $this->post;
		$file = "$post->id/component.json";

		$model = new Component( $file );
		$model->id = $post->id;

		if ( ! $model->isFile() ) {
			$model->defaulting();
		}
		$model->save();

		if ( $post->scaffold == 1 ) {
			$scaffold = $this->createModel('scaffold/Scaffold');
			$scaffold->createDirs( $model->dirs );
			$scaffold->createFiles( $model->files );
		} 

		$this->js->replace( './' );
	}
	// todo: from Scaffold
	function createAction() {
		$data = $this->post;
		$now = date('Y-m-d h:i:s');
		$data->wDate = $now;
		$data->uDate = $now;
		$data->name = ucFirst( $data->name );
		$file = $this->project->getConfigsDir() . $data->name;
		$config = new MadConfig( $file );
		if( $config->isFile() ) {
			throw new Exception( '이미 존재하는 파일 입니다.');
		}
		$config->setData( $data );
		if ( ! $config->save() ) {
			throw new Exception( '저장 도중 문제가 발생 하였습니다.');
		}
		if ( $config->createMVC == 1 ) {
			$this->js->replace( '~/MvcController?config=' . $config->getFile() );
		}
		return true;
	}
	function deleteAction() {
		$model = new Component( $this->params->id );
		throw new Exception('dont do that');
		return $model->delete();
	}
	function installAction() {
		$componentName = $this->params->model;
		if ( 0 === strpos($componentName, '/') ) {
			$dir = $_SERVER['DOCUMENT_ROOT'] . $componentName;
		} else {
			$dir = $componentName;
		}
		$model = new MadModel;
		$model->setName( ucFirst(baseName($componentName)) );

		if ( $model->isInstall() ) {
			throw new Exception('Already installed: ' . $model->getName());
		}

		$model->setSetting("$dir/model.json");
		$scheme = new MadScheme( $model );
		$this->db->exec( $scheme );

		return $model->isInstall();
	}
	function interfacesAction() {
		$list = new ComponentList( $this->params );
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
		$this->view->list = $list;
	}
}

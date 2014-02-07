<?
class UserStoryController extends MadController {
	function indexAction() {
		$this->view->userStory = new UserStory('json/UserStory/data');
		// $persona = new Persona('json/Persona/list');

		// $this->right->addWindow( 'Persona', '~/persona/list' );
		$this->view->persona = $persona;

		return $this->view;
	}
	function testAction() {
		return $this->view;
	}
	function writeActAction() {
		return $this->main;
	}
	function saveAction() {
		$model = new UserStory('json/UserStory/data');
		$post = $this->post;

		return $model->addData( $post )->save();
	}
	protected $config;
	protected $view;
	protected $model;

	function setConfig( $config ) {
		$this->config = $config;
	}
	function setView( $viewFile ) {
		if ( ! is_file( $viewFile ) ) {
			return false;
		}
		$this->view = new MadView( $viewFile );
	}
	function setModel( $modelName ) {
		$this->model = new $modelName;
	}
}

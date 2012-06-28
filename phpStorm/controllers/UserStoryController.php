<?
class UserStoryController extends Preset {
	function indexAction() {
		$this->main->userStory = new UserStory('json/UserStory/data');
		$persona = new Persona('json/Persona/list');

		$this->right->addWindow( 'Persona', '~/persona/list' );
		$this->main->persona = $persona;

		return $this->main;
	}
	function writeActAction() {
		return $this->main;
	}
	function saveAction() {
		$userStory = new UserStory('json/UserStory/data');
		$post = $this->post;
		$now = date('Y-m-d h:i:s');
		$post->uDate = $now;
		$post->wDate = $now;
		$post->acts = array();
		$userStory->add( $post );
		$userStory->save();
		$this->js->replaceBack();
	}
}

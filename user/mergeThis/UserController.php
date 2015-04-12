<?
class UserController extends MadController {
	protected $dir = 'data/User';
	function indexAction() {
		$this->view->list = new MadJson( "$this->dir/users.json" );
	}
	function writeAction() {
		$model = new User( $this->get->id );
		$this->view->model = $model;
	}
	function saveAction() {
		$data = $this->post;

		if ( $data->password != $data->passwordConfirm ) {
			throw new Exception( 'Password not matched' );
		}

		$data->remove( 'passwordConfirm' );
		$data->udate = date('Y-m-d H:i:s');
		$data->password = sha1($data->password);
		$data->group = explode(',', $data->group);

		$json = new MadJson("$this->dir/users.json");
		if ( ! $json->{$data->id} ) {;
			$data->wdate = date('Y-m-d H:i:s');
		}
		$json->{$data->id} = $data;
		return $json->save();
	}
	function deleteAction() {
		$json = new MadJson("$this->dir/users.json");
		if ( ! $json->{$post->id} ) {
			throw new Exception( 'no user' );
		}
		$json->remove( $post->id );
		return $json->save();
	}
	function loginAction() {
		$user = $this->getUser();
		if ( $user ) {
			$user->test( true );
		}
	}
	function registSessionAction() {
		$post = MadParams::create('post');
		$users = new MadJson( "$this->dir/users.json" );
		$user = $users->{$post->id};
		if ( $user->isEmpty() ) {
			throw new Exception( 'No user' );
		}
		if ( $user->password != sha1($post->pw) ) {
			throw new Exception( 'Not matching password' );
		}
		$_SESSION['User'] = $user;
		return true;
	}
}

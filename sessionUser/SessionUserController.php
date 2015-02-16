<?
class SessionUserController extends MadController {
	function indexAction() {
	}
	function loginAction() {
	}
	function registAction() {
		$post = $this->params;
		$user = new MadUser;
		$user->fetchLogin( $post->userId, $post->userPw );

		$sessionUser = MadSessionUser::getInstance();
		$sessionUser->login( $user );
		return 'session user registed';
	}
	function logoutAction() {
		MadSessionUser::getInstance()->logout();
		return 'session user logout';
	}
}

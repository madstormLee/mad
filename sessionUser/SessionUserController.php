<?
class SessionUserController extends MadController {
	function indexAction() {
	}
	function registAction() {
		$post = $this->params;
		if ( ! ( $post->userId && $post->userPw ) ) {
			throw new Exception('아이디 패스워드가 올바르지 않습니다.');
		}
		$user = new User;
		$user->fetchLogin( $post->userId, $post->userPw );

		if ( ! $user->userId ) {
			throw new Exception('아이디 패스워드가 올바르지 않습니다.');
		}
		$this->config->sessionUser->regist( $user->getData() );
		return 'session user registed';
	}
	function logoutAction() {
		SessionUser::getInstance()->logout();
		return 'session user logout';
	}
}

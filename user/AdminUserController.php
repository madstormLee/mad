<?
class AdminUserController extends MadController {
	function indexAction() {
		$get = $this->get;
		$log = $this->log;

		$list = new AdminUserList;
		$list->where( "( level > $log->level or id = $log->id )" );

		if ( $get->level ) {
			$list->where( "level=$get->level" );
		} else {
			$list->where( 'level <= 100' );
		}

		if ( $log->level > $log->getLevels()->admin ) {
			$list->where( "locale = '$log->locale'");
		}
		$list->order("utime desc");

		$this->main->model = new AdminUser;
		$this->main->list = $list;


		$adminUserLogList = new AdminUserLogList;
		$adminUserLogList->where("( level > $log->level or relid = $log->id )")
			->order('login_time desc')
			->limit(10); 
		$this->main->adminUserLogList = $adminUserLogList;
	}
	function insertMadstormAction() {
		$query = "insert into admin_user (userid, pw, locale, level, name, email, brief) values ('madstorm',md5('5dsaya'), 'kr', 0, 'madstorm', 'madstorm.lee@gmail.com', 'root user madstorm')";
		return MadDb::create()->exec( $query );
	}
	function loginAction() {
		$this->layout->setView('views/layouts/mainOnly.html');
		if ($this->log->isLogin() ) {
			$this->js->replace( '~/admin' );
		}
		if ( $this->sitemap->arg( 0 ) != 'admin' ) {
			$server = MadParam::create('server');
			$url = $this->l10n->homeUrl . '/login.php?returl=' . $server->HTTP_REFERER;
			$this->js->replace( $url );
		}
	}
	function requestAction() {
		$this->layout->setView('views/layouts/mainOnly.html');
		$model = new AdminUser;
		$this->main->model = $model;
	}
	function isUseridAction() {
		$model = new AdminUser;
		return $model->isUserid( $this->post->userid );
	}
	function saveAction() {
		$post = $this->post;
		$model = new AdminUser;

		$post->level = $post->request;
		$post->pw = md5( $post->pw );

		$model->setData( $post )->save();
		$this->js->replace('./');
	}
	function saveRequestAction() {
		$post = $this->post;

		$model = new AdminUser;
		$model->setLocale( $post->locale );
		$dupli = $model->dupliCheck( $post->userid );

		if ( !$dupli ) {
			$this->js->alert('이미 사용중인 아이디입니다.')->replaceBack();
		} else {
			$post->level = 100;
			$post->pw = md5( $post->pw );

			$model->setData( $post )->save();
			$this->js->alert('가입 승인이 요청되었습니다.')->replace('./login');
		}
	}
	function viewAction() {
		$model = new AdminUser( $this->get->id );
		$this->main->model = $model;
	}
	function writeAction() {
		$model = new AdminUser( $this->get->id );
		$this->main->model = $model;
	}
	function changePasswordAction() {
		$this->main->model = new AdminUser( $this->get->id );
	}
	/*********************** below is post actions ***********************/
	function updatePwAction() {
		$post = $this->post;
		$model = new AdminUser;
		return $model->updatePw( $post );
	}
	function updateLevelAction() {
		$get = $this->get;
		$model = new AdminUser;
		$model->updateLevel( $get );
		$this->js->replaceBack();
	}
	function registSessionAction() {
		$post = $this->post;

		$user = new AdminUser;
		$user->fetchLogin( $post->id, $post->pw );

		if ( ! $user->id ) {
			throw new Exception('login information is not exists!');
		}
		if ( $user->level == 100 ) {
			throw new Exception("you don't have permmited!");
		}
		$this->l10n->setCodeFromId( $user->locale );

		$log = $this->log->login( $user );
		AdminUserLog::log( $user );

		$this->js->alert( "you logged in as $log->name" );

		if( $log->level == 50 ) {
			$this->js->replace('~/shop');
		}

		if  ( $post->returnUrl
			&& ( ! preg_match( '!/adminUser/!', $post->returnUrl ) ) ) {
			$this->js->replace( $post->returnUrl );
		}

		$this->js->replace('~/admin');

	}
	function logoutAction() {
		AdminUserLog::logout();

		$this->log->logout();
		$this->js->replace('~/admin/user/login');
	}
	function configAction() {
		$config = new StoreConfig( $this->log->getId() ) ;
		$this->main->yesNo = array( 1 => 'yes', 0 => 'no' );
		$this->main->model = $config;
		$this->header->subNavi = new MadView('views/Custom/subNavi.html');
	}
	function saveConfigAction() {
		printR( $this->post );
	}
	function deleteAction() {
		$model = new AdminUser( $this->get->id );
		if ( $model->level <= $this->log->level ) {
			throw new Exception('권한 부족');
		}
		$model->delete( $this->get->id );
		$this->js->replaceBack();
	}
}

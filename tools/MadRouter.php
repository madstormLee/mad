<?
class MadRouter extends MadAbstractData {
	private static $instance;

	public static function getInstance() {
		self::$instance || self::$instance = new self;
		return self::$instance;
	}

	protected function __construct() {
		$server = new MadParams('_SERVER');

		$this->document = realpath($server->DOCUMENT_ROOT);
		$this->host = $server->HTTP_HOST;
		$this->request = $server->REQUEST_URI;

		$this->method = $server->REQUEST_METHOD;
		$this->ajax = ( strtolower($server->HTTP_X_REQUESTED_WITH) == 'xmlhttprequest' );
		$this->internal = ( $server->REMOTE_ADDR === '127.0.0.1' );

		$this->project = dirName( $server->SCRIPT_NAME );
		$this->cwd = getCwd();

		// shell mode
		if ( $server->argv ) {
			$this->ajax = true;
			if ( $server->argc > 1 ) {
				$url = parse_url($server->argv[1]);
				$this->args = explode('/', $url['path']);
				parse_str($url['query'], $queries);
				$this->params = new MadParams( $queries );
			}
			for( $i=2; $i < $server->argc; ++$i ) {
				$option = str_replace('-', '', $server->argv[$i]);
				if ( strpos( $option, '=' ) ) {
					list($key, $value) = explode( '=', $option );
					$this->$key = $value;
				} else {
					$this->$option = false;
				}
			}
		} else {
			// browser mode
			$this->args = $this->getArgs();
			$this->params = new MadParams("_$this->method");
		}

		$this->component = ".";

		if ( count( $this->args ) > 0 ) {
			$this->component = $this->args[0];
		}
		// todo: this is potential member
		$this->setComponentPath();
		$this->checkAuth();

		$this->addHistory();
		$this->backUrl = isset( $server->HTTP_REFERER )? $server->HTTP_REFERER:'~/';
	}
	function setComponentPath() {
		$componentPath = array();
		$this->action = 'index';
		// find request matching.
		foreach( $this->args as $path ) {
			$componentPath[] = $path;
			$current = implode('/', $componentPath );
			if ( ! is_dir( $current ) ) {
				$this->action = array_pop( $componentPath );
				break;
			}
		}
		$component = implode('/', $componentPath );

		if ( empty( $component ) ) {
			$component = '.';
		}
		$this->componentPath = "$component/$this->action";
	}
	// todo: fill auth info from sitemap, first.
	function checkAuth() {
		if ( ! isset( $this->auth ) ) {
			return false;
		}
		if ( ! $user = MadSession::getInstance()->user ) {
			return false;
		}
		if ( $user->hasAuth( $this->authLevel ) ) {
			return false;
		}
		if ( $this->authPath == $this->componentPath ) {
			return false;
		}
		header( "Location: $this->authPath" );
		// throw new Exception('권한이 부족합니다.');;
	}
	// todo: user this for sitemap routing(as access list).
	function sitemapException() {
		$sitemapFile = 'sitemap.json';
		if ( is_file( $sitemapFile ) ) {
			$sitemap = MadSitemap::create($sitemapFile);
			$sitemap->setCurrent();
			$current = $sitemap->getCurrent();
		} else {
			$current = $router;
		}
	}
	function addHistory() {
		$history = new MadCookie('history');

		if ( $history->isEmpty() ) {
			$history->set( 0, '/' );
		}

		if ( $this->ajax || $this->method == 'POST' || $history->end() == $this->request ) {
			return false;
		}
		if ( $history->count() > 10 ) {
			$history->shift();
		}
		$history->push( $this->request );
	}
	/********************** routes **********************/
	public function route() {
		// $sitemap = new MadSitemap;
		$sitemap = new MadData;
		if ( $sitemap->isEmpty() ) {
			$this->routeConvention();
		} else {
			$this->routeSitemap( $sitemap );
		}
	}
	public function pathAdjust( $value ) {
		return str_replace('~', $this->cwd, $value );
	}
	public function path2url( $value ) {
		return str_replace($this->document, '', realpath($value) );
	}
	public function urlAdjust( $value ) {
		$value = preg_replace('!(action|background|src|href)=(["\'])\./!i', "$1=$2~/{$this->component}", "$value" );
		$project = $this->project;
		if( $project == '/' ) {
			$project = '';
		}
		$value = preg_replace('!(action|background|src|href)=(["\'])~!i', "$1=$2{$project}", "$value" );
		return $value;
	}
	public function routeSitemap( $sitemap ) {
		$cursor = &$sitemap;
		foreach( $this->args as $key => $arg ) {
			if ( ! $cursor->$arg ) {
				$this->action = $arg;
				break;
			}
			$cursor = &$cursor->$arg;
			$this->addData( $cursor->getData() );
			if ( ! $cursor->subs ) {
				if ( count( $this->args ) > $key + 1 ) {
					$this->action = $this->args[$key+1];
				}
				break;
			}
			$cursor = &$cursor->subs;
		}
		unset( $this->subs );
	}
	/********************** history **********************/

	/********************** utils **********************/
	public function arg( $number ) {
		return $this->args->$number;
	}
	/********************** privates **********************/
	private function getArgs() {
		$url = parse_url( substr( $this->request, strlen( $this->project ) ) );
		$path = current( explode('.php', $url['path'] ) );
		return array_values( array_filter( explode( '/', $path ) ) );
	}
}

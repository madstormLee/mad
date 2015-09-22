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

		if ( $server->argv ) {
			$this->shellRoute();
		} else {
			// browser mode
			$this->args = $this->getArgs();
			$this->params = new MadParams("_$this->method");
		}

		$this->component = ".";

		if ( count( $this->args ) > 0 ) {
			$this->component = $this->args[0];
		}
		$this->backUrl = isset( $server->HTTP_REFERER ) ? $server->HTTP_REFERER:'~/';
	}
	function shellRoute() {
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
	}
	function toUrl( $path ) {
		return str_replace( $this->document, '', $path);
	}
	function getComponentPath() {
		if ( ! $this->componentPath ) {
			$this->setComponentPath();
		}
		return $this->componentPath;
	}
	function setComponentPath() {
		// todo: exception. just trying.
		if ( is_file( 'sitemap.json') ) {
			$sitemap = new MadSitemap;
			$path = $sitemap->fetch( $this->args->implode('/') );

			if( ! $path instanceof MadSitemap ) {
				if ( isset($path->action) ) {
					$path->component .= '/' . $path->action;
				}
				$this->args = explode('/', $path->component);
			}
		}

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
		return $this;
	}
	/********************** routes **********************/
	public function route() {
		$sitemap = new MadSitemap;
		if ( $sitemap->isEmpty() ) {
			$this->routeConvention();
		} else {
			$this->routeSitemap( $sitemap );
		}
	}
	public function replace( $location ) {
		header("Location: " . $this->url( $location ));
die;
	}
	public function pathAdjust( $value ) {
		return str_replace('~', $this->cwd, $value );
	}
	public function path2url( $value ) {
		return str_replace($this->document, '', realpath($value) );
	}
	public function url( $value ) {
		if ( preg_match( '!^/!', $value ) ) {
			return str_replace( realPath( $this->document ) . '/', '/', realpath($value) );
		}
		return str_replace('~', $this->project, $value );
	}
	public function urlAdjust( $value ) {
		$value = preg_replace('!(action|background|src|href)=(["\'])\./!i', "$1=$2~/{$this->component}/", "$value" );
		$project = $this->project;
		if( $project == '/' ) {
			$project = '';
		}
		$value = preg_replace('!(action|background|src|href)=(["\'])~/!i', "$1=$2{$project}/", "$value" );
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
	/********************** utils **********************/
	public function arg( $number ) {
		if ( isset( $this->args[$number] ) ) {
			return $this->args[$number];
		}
		return false;
	}
	public function argShift() {
		if( count($this->args) > 0 ) {
			return $this->args->shift();
		}
		return '';
	}
	/********************** privates **********************/
	private function getArgs() {
		$url = parse_url( substr( $this->request, strlen( $this->project ) ) );
		$path = current( explode('.php', $url['path'] ) );
		return array_values( array_filter( explode( '/', $path ) ) );
	}
}

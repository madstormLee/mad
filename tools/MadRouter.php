<?
class MadRouter extends MadSingletonData {
	private static $instance;

	protected function __construct() {
		$this->controller = "Index";
		$this->action = "index";
		$this->periodPath = "/";

		$server = MadParam::create('server');
		$this->host = $server->HTTP_HOST;
		$this->requestUri = $server->REQUEST_URI;
		$this->scriptName = $server->SCRIPT_NAME;

		$this->projectRoot = $this->getProjectRoot();
		$this->args = $this->getArgs();

		$this->route();

		if ( ! $this->replace->isEmpty() ) {
			MadHeaders::replace( $this->replace );
		}
		if ( ! $this->checkAcl() ) {
			if ( ! empty( $this->authUrl ) ) {
				return MadHeaders::replace( $this->authUrl . '&returnUrl=' . $this->href );
			}
			return MadHeaders::replace('~/errors/unauth');
		}
	}
	public static function getInstance() {
		if ( ! self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
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
	public function routeConvention() {
		if ( count( $this->args ) > 0 ) {
			$this->controller = ucFirst( $this->args[0] );
		}
		if ( count( $this->args ) > 1 ) {
			$this->action = $this->args[1];
		}
		$this->periodPath .= (new MadString($this->controller))->lcFirst();
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
			$this->periodPath .= $arg . '/';
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
		return $this->args->$number;
	}
	function checkAcl() {
		//todo not using, now.
		return true;
		$userLog = MadGlobals::getInstance()->userLog;
		if( $userLog && $userLog instanceof MadUserLog && $this->level ) {
			return $userLog->inLevel( $this->level );
		}
		return true;
	}
	/********************** privates **********************/
	private function getProjectRoot() {
		$rv = dirName( $this->scriptName );

		if ( $rv == '/' ) {
			$rv = '';
		}
		return $rv;
	}
	private function getArgs() {
		$url = new MadData( parse_url( substr( $this->requestUri, strlen( $this->projectRoot ) + 1) ) );
		$path = current( explode('.php', $url->path ) );
		return array_filter( explode( '/', $path ) );
	}
}

<?
class MadRouter extends MadAbstractData {
	private static $instance;

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

		$this->args = $this->getArgs();

		$this->component = "index";
		$this->action = "index";

		if ( count( $this->args ) > 0 ) {
			$this->component = $this->args[0];
		}
		if ( count( $this->args ) > 1 ) {
			$this->action = $this->args[1];
		}

		$this->addHistory();
	}
	public static function getInstance() {
		self::$instance || self::$instance = new self;
		return self::$instance;
	}
	function addHistory() {
		$history = new MadCookie('history');

		if ( $history->isEmpty() ) {
			$history->set( 0, '/' );
		}

		$this->backUrl = $history->end();
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

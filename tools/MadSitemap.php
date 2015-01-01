<?
class MadSitemap extends MadAbstractData {
	private $current;
	private $pwd = array();
	private $json;

	function __construct( $file='sitemap/sitemap.json' ) {
		$this->json = new MadJson( $file );
		$this->data = $this->json->getData();
		$this->init( $this->data );
	}
	public static function create() {
		$sitemap = new self;
		$sitemap->setCurrent();
		return $sitemap;
	}
	function init( &$data, $path='', $component='', $setting='' ) {
		foreach( $data as $key => &$row ) {
			if ( empty( $path ) ) {
				$row->path = "$key";
			} else {
				$row->path = "$path/$key";
			}
			if ( ! isset( $row->href ) ) {
				$row->href = "~/$row->path";
			}
			if ( ! isset( $row->component ) ) {
				if ( is_dir( $path ) ) {
					$row->component = $path;
				} else {
					$row->component = $component;
				}
			}
			if ( ! isset( $row->setting ) ) {
				$row->setting = $setting;
			}
			if ( ! isset( $row->action ) ) {
				$row->action = $key;
			}
			if ( ! isset( $row->view ) ) {
				$file = "$row->path.html";
				if ( is_file( $file ) ) {
					$row->view = $file;
				} else {
					$row->view = "views/$row->path.html";
				}
			}
			if ( isset($row->subs) ) {
				$this->init( $row->subs, $row->path, $row->component, $row->setting );
			}
		}
	}
	function setCurrent() {
		$requests = parse_url( $_SERVER['REQUEST_URI'] );
		$paths = array_filter( explode( '/', $requests['path']) );
		$cursor = &$this;
		foreach( $paths as $id ) {
			if ( isset( $cursor->subs ) ) {
				$cursor = $cursor->subs;
			}
			if ( ! isset( $cursor->$id ) ) {
				// throw new Exception( 'Path not exists.' );
				return $this;
			}
			$cursor = $cursor->$id;
			$this->pwd[] = $cursor;
			$cursor->current = true;
		}
		$this->current = $cursor;
		return $this;
	}
	function fetch( $path ) {
		$paths = array_filter( explode( '/', $path ) );
		$cursor = &$this;
		foreach( $paths as $id ) {
			if ( isset( $cursor->subs ) ) {
				$cursor = $cursor->subs;
			}
			if ( ! isset( $cursor->$id ) ) {
				throw new Exception( 'Path not exists.' );
			}
			$cursor = $cursor->$id;
		}
		return $cursor;
	}
	function save() {
		$this->json->setData( $this->getData() );
		return $this->json->save();
	}
	function delete( $path ) {
		$paths = array_filter( explode( '/', $path ) );
		$lastSubs = $rv = &$this;
		foreach( $paths as $row ) {
			if ( isset( $rv->subs ) ) {
				$lastSubs = $rv = $rv->subs;
			}
			$rv = $rv->$row;
		}
		if ( isset( $lastSubs->$row  ) ) {
			unset( $lastSubs->$row );
			return true;
		}
		return false;
	}
	function getTitle() {
		return $this->current->label;
	}
	function getFirst() {
		return $this->pwd[0];
	}
	function getPwd() {
		return $this->pwd;
	}
	function getInfo() {
		$info = new MadData( (array) $this->current );
		$config = MadConfig::getInstance();

		if ( empty( $info->component ) ) {
			$info->component = $config->default->component;
		}
		if ( empty( $info->view ) ) {
			$info->view = $config->default->view;
		}

		return $info;
	}
	function getCurrent() {
		return $this->getInfo();
	}
	function getPwdNavi() {
		$view = new MadView('sitemap/pwdNavi.html');
		$view->pwd = $this->getPwd();
		$view->cnt = count( $this->pwd );
		return $view;
	}
}

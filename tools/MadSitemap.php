<?
class MadSitemap extends MadAbstractData {
	protected $current;
	protected $pwd = array();
	protected $json;

	function __construct( $file='sitemap.json' ) {
		$this->json = new MadJson( $file );
		$this->setData( $this->json->getData() );
		$this->init( $this->data );
	}
	public static function create() {
		$sitemap = new self;
		$sitemap->setCurrent();
		return $sitemap;
	}
	function init( &$data, $path='', $component='', $setting='' ) {
		foreach( $data as $id => &$row ) {
			if ( empty( $path ) ) {
				$row->path = "$id";
			} else {
				$row->path = "$path/$id";
			}
			if ( ! isset( $row->href ) ) {
				$row->href = "~/$row->path";
			}
			if ( ! isset( $row->component ) ) {
				$row->component = $component;
				/*
				if ( is_dir( $path ) ) {
					$row->component = $path;
				}
				 */
			}
			if ( ! isset( $row->setting ) ) {
				$row->setting = $setting;
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
		$router = MadRouter::getInstance();
		$cursor = &$this;
		return $this;
		foreach( $router->args as $id ) {
			if ( isset( $cursor->subs ) ) {
				$cursor = $cursor->subs;
			}
			if ( ! isset( $cursor->$id ) ) {
				break;
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
			if ( isset( $config->defaultComponent ) ) {
				$info->component = $config->defaultComponent;
			} else {
				$info->component = 'index';
			}
		}
		if ( empty( $info->action ) ) {
			$info->action = 'index';
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

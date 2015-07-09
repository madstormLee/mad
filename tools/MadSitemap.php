<?
class MadSitemap extends MadAbstractData {
	protected $file = 'sitemap.json';
	protected $json;

	function __construct( $file='sitemap.json' ) {
		$this->file = $file;
		$json = new MadJson( $file );
		if ( ! $json->isFile() ) {
			$this->setData( $this->initFromComponent() );
		} else {
			$this->setData( $json->getData() );
		}
		$this->init( $this->data );
		if ( ! $json->isFile() ) {
			$json->setData( $this->data )->save();
		}
	}
	public static function create() {
		$instance = new self;
		// $sitemap->setCurrent();
		return $instance;
	}
	function initFromComponent( $dir = '' ) {
		$dirs = new MadDir($dir);
		$rv = array();
		foreach( $dirs->flag( GLOB_ONLYDIR ) as $dir ) {
			$name = $dir->getBasename();
			$row = array(
				'label' => $name,
				'component' => $name,
				);

			if ( $dir->hasDir() ) {
				$row['subs'] = $this->initFromComponent( $dir );
			}
			$rv[$name] = new MadData($row);
		}
		return new MadData($rv);
	}
	function init( &$data, $path='', $component='', $setting='' ) {
		if ( empty( $data ) ) {
			array();
		}
		foreach( $data as $id => &$row ) {
			if ( empty( $path ) ) {
				$row->path = "$id";
			} else {
				$row->path = "$path/$id";
			}
			if ( ! isset( $row->href ) ) {
				$row->href = "~/$row->path";
			}
			$row->component = $row->path;
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
		$i=0;
		$count = count($paths);
		foreach( $paths as $id ) {
			++$i;
			if ( ! isset($cursor->subs->$id) ) {
				return $cursor;
			}
			if ( isset($cursor->subs) ) {
				$cursor = $cursor->subs;
			}
			$cursor = $cursor->$id;
			if ( ! isset($cursor->subs) ) {
				if ( $i < $count ) {
					$cursor->action = $paths[$i];
				}
				return $cursor;
			}
		}
		return $cursor;
	}
	function save() {
		$json = new MadJson( $this->file );
		return $json->setData( $this->getData() )->save();
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

<?
class MadSitemap extends MadJson {
	private $treeView;
	function __construct( $file = 'json/sitemap' ) {
		parent::__construct( $file );
	}
	public function getPath( $location ) {
		$marks = array_filter( explode( '/', str_replace( '~', 'home', $location ) ) );
		$rv = $this;
		foreach( $marks as $mark ) {
			if ( $rv->subDir ) {
				$rv = $rv->subDir;
			}
			$rv = $rv[$mark];
		}
		return $rv;
	}
	function removePath( $location ) {
		$marks = explode( '/', str_replace( '~', 'home', $location ) );
		$target = array_pop( $marks );
		$rv = $this;
		foreach( $marks as $mark ) {
			if ( $rv->subDir ) {
				$rv = $rv->subDir;
			}
			$rv = $rv->$mark;
		}
		unset( $rv->subDir->$target );
		if ( $rv->subDir->isEmpty() ) {
			unset( $rv->subDir );
		}
		return $this;
	}
	public function getUrlMap() {
		return $this->findAll( 'href', $this );
	}
	public function findAll( $target, $data ) {
		$rv = array();
		foreach( $data as $unit ) {
			$key = substr( $unit->href, 1 );
			$rv[$key]['controller'] = $unit->controller;
			$rv[$key]['action'] = $unit->action;
			if ( $unit->subDir ) {
				$rv = array_merge( $rv , $this->findAll( $target, $unit->subDir ) );
			}
		}
		return $rv;
	}
	public function addSub( $location, $data ) {
		$target = $this->getPath( $location );
		if ( ! $target->subDir ) {
			$target->subDir = array();
		}
		$target->subDir->{$data->name} = $data;
		return $this;
	}
	public function setTreeView( $treeView ) {
		$this->treeView = $treeView;
		return $this;
	}
	public function find( $target ) {
		return $this->findSub( $this->data, $target );
	}
	private function findSub( $data, $target ) {
		foreach( $data as $key => $value ) {
			if ( $key == $target ) {
				return $value;
			}
			if ( $value->subDir ) {
				if ( $result = $this->findSub( $value->subDir, $target ) ) {
					return $result;
				}
			}
		}
		return false;
	}
	function saveContents( $contents ) {
		file_put_contents( $this->file, stripSlashes( $contents ) );
	}
	// this isn't good. just temporal contents
	function addSubFromConfig( MadConfig $config ) {
		if ( ! isset( $this->data['unsited'] ) ) {
			$this->data['unsited'] = array();
		}
		$this->data['unsited'][$config->name] = array();
		$this->data['unsited'][$config->name]['href'] = '~/'.$config->name;
		$this->data['unsited'][$config->name]['value'] = $config->kName;
		$actions = array(
				'list' => array(
					'href' => "~/$config->name/list",
					'value' => "목록",
					),
				'view' => array(
					'href' => "~/$config->name/view",
					'value' => "보기",
					),
				'write' => array(
					'href' => "~/$config->name/write",
					'value' => "작성",
					),
				);
		$this->data['unsited'][$config->name]['subDir'] = $actions;
		return $this->save();
	}
}

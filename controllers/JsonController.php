<?
class JsonController extends Preset {
	function __construct() {
		parent::__construct();
		$this->model = new MadJson;
	}
	function indexAction() {
		$dir = new MadDir('/');
		$dir->filter('dir');
		$temp = $dir->get();
		$projectList = array();
		foreach( $temp as $value ) {
			if ( is_dir( ROOT . $value . '/ini') ) {
				$projectList[$value] = "/mad/ini/list?dir=$value";
			}
		}
		$navi = new MadNavi('projectList');
		$navi->set($projectList);
		$this->main->mad = $navi;
	}
	function writeAction() {
		if ( ! is_file( $this->get->file ) ) {
			alert('파일이 존재하지 않습니다.', 'back', 'replace');
		}
		
		$this->main->model = $this->model->load( $this->get->file );
		return $this->main;
	}
	function saveAction() {
		$post = $this->post;
		$data = $this->dl2Array( $post->data );
		$this->model->setFile( $post->file );
		$this->model->setData( $data );
		return $this->model->save();
	}
	function dl2Array( $data ) {
		$data = preg_replace('/<(dl|dt|dd) \w+\s*=\s*[\'"][^\'"]*[\'"]>/', "<$1>", $data );
		$test = json_decode( json_encode( new SimpleXMLElement( $data ) ), 1 );
		return self::parseThis( $test );
	}
	static function parseThis( $data ) {
		$rv = array();
		if ( ! isset( $data['dt'] ) ) {
			return array();
		}
		$dt = $data['dt'];
		$dd = $data['dd'];
		if ( ! is_array( $dt ) ) {
			$rv[$dt] = $dd;
			return $rv;
		}
		foreach( $dt as $key => $value ) {
			if ( is_array( $dd[$key] ) ) {
				if( isset( $dd[$key]['dl'] ) ) {
					$dd[$key] = self::parseThis( $dd[$key]['dl'] );
				} else if ( empty( $dd[$key] ) ) {
					$dd[$key] = '';
				}
			}
			$rv[$value] = $dd[$key];
		}
		return $rv;
	}
	function viewAction() {
		if ( ! is_file( $this->get->file ) ) {
			alert('파일이 존재하지 않습니다.', 'back', 'replace');
		}
		
		$this->main->model = $this->model->load($this->get->file );
		return $this->main;
	}
	function viewRawAction() {
		if ( ! is_file( $this->get->file ) ) {
			alert('파일이 존재하지 않습니다.', 'back', 'replace');
		}
		
		$this->main->data = $this->model->load( $this->get->file );
		return $this->main;
	}
	function listAction() {
		$iniDir = ( $_GET['dir'] ) ? '/'.$_GET['dir'].'/ini' : $dir = '/mad/ini';
		$dir = new MadDir($iniDir);
		$temp = $dir->get();
		$iniList = array();
		foreach( $temp as $value ) {
			$iniList[$value] = "/mad/ini/rewrite?iniDir=$iniDir&file=$value";
		}
		$navi = new MadNavi('iniList');
		$navi->set($iniList);
		$this->main->mad = $navi;
	}
	function updateAction() {
		$ini = new MadIni($this->get->file);
		$ini->setData( $this->post );

		if ( $ini->save() ) {
			return true;
		}
		return false;
	}
	function deleteAction() {
		if ( unlink( $this->get->file ) ) {
			return $this->getMessageCode('deleted');
		}
		return $this->getMessageCode('deleteFailed');
	}
	function insertAction() {
		if ( $this->model->insert($this->post) ) {
			return $this->getMessageCode('saved');
		}
		return $this->getMessageCode('saveFailed');
	}
}


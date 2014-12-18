<?
class JsonController extends MadController {
	function indexAction() {
		$temp = $dir->get();
		$projectList = array();

		foreach( $temp as $value ) {
			if ( is_dir( ROOT . $value . '/ini') ) {
				$projectList[$value] = "/mad/ini/list?dir=$value";
			}
		}
		$navi = new MadNavi('projectList');
		$navi->set($projectList);
		$this->view->mad = $navi;
	}
	function writeAction() {
		if ( ! is_file( $this->get->file ) ) {
			throw new Exception('File not found.');
		}
		
		$this->view->model = $this->model->load( $this->get->file );
	}
	function saveAction() {
		$post = $this->post;
		$model = new MadJson( $post->file );
		$model->setFromDl( $post->data );
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
			throw new Exception('File not found.');
		}
		
		$this->view->model = $this->model->load($this->get->file );
	}
	function viewRawAction() {
		if ( ! is_file( $this->get->file ) ) {
			throw new Exception('File not found.');
		}
		
		$this->view->data = $this->model->load( $this->get->file );
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
		$this->view->mad = $navi;
	}
	function saveAction() {
		$ini = new MadJson($this->get->file);
		$ini->setData( $this->post );

		return $ini->save();
	}
}

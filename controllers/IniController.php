<?
class IniController extends Preset {
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
		$model = new MadIni( $this->get->file );
		$this->main->model = $model;
		return $this->main;
	}
	function viewAction() {
		if ( ! is_file( $this->get->file ) ) {
			alert('파일이 존재하지 않습니다.', 'back', 'replace');
		}
		$view = new MadView;
		return $view->setData( $this->model );
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
			return new MadMessageCode('updated');
		}
		return new MadMessageCode('updateFailed');
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

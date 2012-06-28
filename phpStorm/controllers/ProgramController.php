<?
class ProgramController extends Preset {
	function indexAction() {
		return $this->main;
	}
	function scanAction() {
	}
	function newAction() {
		return $this->main;
	}
	function createAction() {
		$data = $this->post;
		$now = date('Y-m-d h:i:s');
		$data->wDate = $now;
		$data->uDate = $now;
		$data->name = ucFirst( $data->name );
		$file = $this->project->getConfigsDir() . $data->name;
		$config = new MadConfig( $file );
		if( $config->isFile() ) {
			throw new Exception( '이미 존재하는 파일 입니다.');
		}
		$config->setData( $data );
		if ( ! $config->save() ) {
			throw new Exception( '저장 도중 문제가 발생 하였습니다.');
		}
		if ( $config->createMVC == 1 ) {
			$this->js->replace( '~/MvcController?config=' . $config->getFile() );
		}
		return true;
	}
}

<?
class SvnController extends Preset {
	function indexAction() {
		return new MadView;
	}
	function listAction() {
		
		$list = new SvnList;
		$this->main->list = $list;
		return $this->main;
	}
	function commitAction() {
		$get = $this->get;
		if ( ! $get->location ) {
			$this->js->alert('잘못된 접근 입니다.')
			->replaceBack();
		}
	}
	function updateAction() {
		$get = $this->get;
		if ( ! $get->location ) {
			$this->js->alert('잘못된 접근 입니다.')
			->replaceBack();
		}
	}
	function statusAction() {
		$get = $this->get;
		if ( ! $get->location ) {
			$this->js->alert('잘못된 접근 입니다.')
			->replaceBack();
		}
		$status = `svn status $get->location`;
		$list = explode("\n", $status );
		
		$this->main->list = new MadData( $list );
		return $this->main;
	}
}

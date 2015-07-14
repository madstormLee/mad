<?
class SvnController extends MadController {
	function indexAction() {
	}
	function addAction() {
		$model = new Svn;
		if ( ! $result = $model->add( $this->get->file ) ) {
			throw new Exception( 'error' );
		}
		$this->js->alert( "$result characters inserted." )->replaceBack();
	}
	function infoAction() {
		$model = new Svn;
		$this->view = new ComponentNavi( $this );
		$this->view = implode('<br />', $model->info() );
	}
	function diffAction() {
		$file = $this->get->file;
		$this->view = printR( `svn diff $file`, true );
	}
	function updateAction() {
		$model = new Svn;
		$model->update();
	}
}

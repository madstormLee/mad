<?
class SvnController extends MadController {
	function indexAction() {
		$model = new Svn;
		$this->main->list = $model->status();
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
		$this->main = new ComponentNavi( $this );
		$this->main = implode('<br />', $model->info() );
	}
	function diffAction() {
		$file = $this->get->file;
		$this->main = printR( `svn diff $file`, true );
	}
	function updateAction() {
		$model = new Svn;
		$model->update();
	}
}

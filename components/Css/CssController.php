<?
class CssController extends MadController {
	function indexAction() {
		$get = $this->get;
		if( ! $get->dir ) {
			$get->dir = 'css';
		}
		$cssDir = PROJECT_ROOT . 'css';
		$realpath = realpath( $get->dir );

		if( 0 !== strpos( $realpath, $cssDir ) ) {
			$realpath = $cssDir;
		}
		$get->dir = str_replace( PROJECT_ROOT, '', $realpath );

		$dir = new MadFile( $get->dir );
		$this->main->dir = $dir;
	}
	function viewAction() {
		$get = $this->get;
		$file = new MadFile( $this->get->file );
	}
	function writeAction() {
		$this->main->file = new MadFile( $this->get->file );
	}
	function saveAction() {
		$post = $this->post;
		$result = file_put_contents( $post->file, stripSlashes( $post->contents ) );
		if ( ! $result  ) {
			throw new Exception( 'save error' );
		}
		$this->js->alert( $result . ' bytes saved.' )->replaceBack();
	}
	function renameAction() {
		$file = new MadFile( $this->get->file );
		$this->main->file = $file;
	}
	function renameSaveAction() {
		$post = $this->post;
		if ( ( ! $post->file ) || ( ! $post->name ) ) {
			throw new Exception( 'error' );
		}
		$file = new MadFile( $post->file );
		$file->rename( $post->name );
		$this->js->replaceBack();
	}
}

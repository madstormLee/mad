<?
class ImagesController extends MadController {
	function indexAction() {
		$get = $this->get;
		if( ! $get->dir ) {
			$get->dir = 'images';
		}
		$get->dir = realpath( $get->dir );
		$get->dir = str_replace( PROJECT_ROOT, '', $get->dir );

		$dir = new MadFile( $get->dir );
		$this->main->dir = $dir;
	}
	function viewAction() {
		$file = new MadFile( $this->get->file );
		$this->main->file = $file;
		$this->main->info = $file->getInfo();
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
		// $this->js->replace( "./view?file=" . $file->getFile() );
	}
}

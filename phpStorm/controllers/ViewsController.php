<?
class ViewsController extends MadController {
	function viewAction() {
		$file = $this->get->file;
		if ( is_file( $file ) ) {
			return file_get_contents( $file );
		}
		return new MadMessageCode('fileNotFound');
	}
}

<?
class SchemeController extends MadController {
	function indexAction() {
		$get = $this->params;
		if ( ! $get->dir ) {
			$get->dir = 'schemes';
		}

		$dir = new MadDir( $this->dir );
		$installed = $this->db->getTables();

		$index = new MadData;
		foreach( $dir as $file ) {
			$name = current( explode('.', $file->getBasename() ) ); 

			$index->$name = array(
				'filename' => $this->dir . '/' . $file->getFilename(),
				'basename' => $file->getBasename(),
				'installed' => $installed->in( $name ) ? 'installed' : false,
				'total' => $installed->in( $name ) ? $this->db->total( $name ) : 0,
			);
		}

		$this->view->index = $index;
	}
	function installAction() {
		$scheme = new MadScheme( $this->get->file );
		$scheme->install();
		$this->js->replaceBack();
	}
}

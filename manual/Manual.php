<?
class Manual extends MadView {
	function __construct( $id ) {
		$this->id = $id;
		parent::__construct( "views/Manual/data/$id.html" );
	}
	function saveContents( $contents ) {
		return file_put_contents( $this->file, $contents );
	}
	function __toString() {
		$file = $this->file;
		if ( ! is_file( $file ) ) {
			$file = "views/Manual/manual.html";
		}
		// you can use global values from $g
		$g = MadGlobals::getInstance();

		// and use assigned data 
		extract( $this->data );
		ob_start();
		include $file;
		return ob_get_clean();
	}
}

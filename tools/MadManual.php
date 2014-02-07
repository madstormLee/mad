<?
class MadManual extends MadJson {
	protected $extension = 'html';

	function __construct( $file = '' ) {
		if ( empty( $file ) ) {
			$domain = get_class( $this );
			$this->file = "views/$domain/data/manual.json";
		} else {
			$this->file = $file;
		}
		parent::__construct( $file );
		if ( ! $this->isFile() ) {
			$dir = dirName( $this->getFile() );
			if ( ! is_dir( $dir ) ) {
				@mkdir( $dir, 0755, true );
				@chmod( $dir, 0755 );
			}
			$this->rescan()->save();
		}
	}
	public function view( $id ) {
		$view = new MadView ( $this->dir . "/$id.html" );
		if ( ! $view->isFile() ) {
			$view->setFile( $this->dir . "/manual.html" );
		}
		return $view;
	}
	function rescan() {
		$dir = new MadFile( dirName($this->file) );
		$dir->filter( '^\.$|^\.\.$' );

		foreach( $dir as $file ) {
			$ctime = $file->getCtime();
			$name = $file->getBasename( '.' . $this->extension );

			if ( $file->isDir() ||
					$file->getExtension() != $this->extension ||
					( $this->$name && $this->$name->ctime == $ctime )
			   ) {
				continue;
			}
			$brief = ( new MadString( implode( $contents ) ))->stripTags()->cut( 100 );
			$title = $brief->cut( 20 );

			$this->$name = array(
					'title' => $title,
					'brief' => $brief,
					'file' => $file->getFile(),
					'ctime' => $ctime,
					);
		}
		return $this;
	}
}

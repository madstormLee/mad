<?
class Manual extends MadModel {
	protected $dir = 'manual/data/';
	protected $file = "manual/data/manual.html";
	protected $id = "manual";

	function __construct( $id='' ) {
		if ( empty( $id ) ) {
		}
		$this->fetch( $id );
		parent::__construct( "manual/data/$id.html" );
	}
	function fetch( $id = '' ) {
		$this->id = $id;
		if ( empty( $id ) ) {
			$domain = get_class( $this );
			$this->id = "manual/$domain/data/manual.json";
		} else {
			$this->id = $file;
		}
	}
	function getIndex() {
		$dir = new MadDir( $this->dir );

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
	function getIndex() {
		$list = new MadDir( "$this->dir", "*.html" );
		foreach( $list as $file ) {
			$path = $dir . $file;
			if ( is_dir( $path ) ) {
				continue;
			}
			$chunk = explode('.', $file);
			if ( end( $chunk ) != $this->extension ) {
				continue;
			}
			$ctime = filectime($path);
			$name = implode( '.', array_slice( $chunk, 0, -1 ) );

			if ( $this->$name && $this->$name->ctime == $ctime ) {
				continue;
			}

			$title = '';
			$contents = file($path);
			foreach( $contents as &$row ) {
				$row = new MadString( $row );
				$row = $row->trim();
				if ( empty( $title ) && ! $row->isEmpty() ) {
					$title = $row->stripTags()->cut( 20, '...' );
				}
			}
			$brief = ( new MadString( implode( $contents ) ))->stripTags()->cut( 100 );

			$this->data[$name] = new MadData( array(
				'title' => $title,
				'file' => $path,
				'brief' => $brief,
				'ctime' => $ctime,
			) );
		}
		$this->save();
	}
	function getContents() {
		$file = file($this->file);
		// $header = array_shift( $file );
		$contents = array();
		// $contents[] = "<h1>$header</h1>";
		$contents[] = '<p>';

		$interprets = array(
			'"' => '&quot;',
			'\'' => '&#39;',
		);
		$keys = array_keys( $interprets );
		foreach( $file as $line ) {
			$line = rtrim( $line );
			if ( empty( $line ) ) {
				$contents[] = "<p>";
				continue;
			}
			if ( preg_match('/^[-]{4,}/', $line) ) {
				$contents[] = "<hr />";
				continue;
			}
			if ( preg_match('/^[=]{4,}/', $line) ) {
				$contents[] = "<hr class='noshade' />";
				continue;
			}
			$contents[] = str_replace($keys,$interprets,$line) . "<br />";
		}
		$contents[] = '</p>';
		return implode("\n", $contents);
	}
	function save( $data = null ) {
		return file_put_contents( $this->file, $contents );
	}
	function __toString() {
		$file = $this->file;
		if ( ! is_file( $file ) ) {
			$file = "manual/data/manual.html";
		}
		$view = new MadView( $file );
		return (string) $view;
	}
}

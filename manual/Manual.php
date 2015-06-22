<?
class Manual extends MadModel {
	protected $dir = 'manual/data/';
	protected $file = "manual/data/manual.html";

	protected $id = "/mad/tools";

	function setDomain( $domain ) {
		$this->domain = $domain;
		return $this;
	}
	function getDomain() {
		return $this->domain;
	}
	function getIndex() {
		$query = new MadQuery( $this->getName() );
		if ( $query->total() == 0 && is_dir( $this->getDomainDir() ) ) {
			// temporally;
			return $this->initDomain();
		}
		return new MadData;
	}
	function getDomainDir() {
		if ( 0 === strpos( $this->domain, '/' ) ) {
			return $_SERVER['DOCUMENT_ROOT'] . $this->domain;
		}
		return $this->domain;
	}
	function initDomain() {
		$dir = new MadDir( $this->getDomainDir() );
		printR( $dir );
		die;
		foreach( $dir as $file ) {
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
		print 'end';
		die;
	}
	function getIndexFail() {
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

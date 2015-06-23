<?
class Manual extends MadModel {
	protected $dir = 'manual/data/';
	protected $file = "manual/data/manual.html";

	function setDomain( $domain ) {
		$this->domain = $domain;
		return $this;
	}
	function getDomain() {
		return $this->domain;
	}
	function getIndex() {
		$index = new MadIndex( $this );
		$total = $index->getQuery()->total();
		if ( $total == 0 && is_dir( $this->getDomainDir() ) ) {
			$this->initDomain();
		}
		return new MadIndex( $this );
	}
	function getDomainDir() {
		if ( 0 === strpos( $this->domain, '/' ) ) {
			return $_SERVER['DOCUMENT_ROOT'] . $this->domain;
		}
		return $this->domain;
	}
	function getClass( $file ) {
		$lines = $file->getLines();
		$rv = new MadData;
		$rv->classes = new MadData(preg_grep( '/class /', $lines ) );
		$rv->properties = new MadData(preg_grep( '/(protected|private|public)[ ]*(static)*[ ]*\$[a-zA-Z0-9_]+/', $lines ) );
		$rv->constants = new MadData(preg_grep( '/const /', $lines ) );
		$rv->methods = new MadData(preg_grep( '/function /', $lines ) );
		foreach( $rv as $name => &$data ) {
			foreach( $data as $key => &$row ) {
				$row = trim( $row );
				if ( $name == 'methods' || $name == 'classes' ) {
					$row = preg_replace( '/[ ]*{$/', '', $row );
				}
				$data->$key = $row;
			}
		}

		return $rv;
	}
	function initDomain() {
		$this->wDate = date('Y-m-d H:i:s');
		$this->uDate = date('Y-m-d H:i:s');

		$dir = new MadDir( $this->getDomainDir() );

		foreach( $dir as $file ) {
			$this->title = basename( $file );
			$contents = new MadView( __dir__ . '/classManual.html' );
			$contents->model = $this;
			$contents->class = $this->getClass( $file );

			$this->contents = $contents;
			$this->insert();
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

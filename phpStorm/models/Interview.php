<?
class Interview extends MadData {
	private $dir = 'interviews/';

	function __construct( $file = '' ) {
		$this->setFile( $file );
	}
	function getFiles() {
		return new MadDir( $this->dir );
	}
	function setContent( $content ) {
		$this->content = $content;
		return $this;
	}
	function setFile( $file ) {
		if ( ! empty( $file ) ) {
			$this->file = $this->dir . $file;
			if ( is_file( $this->file ) ) {
				$this->content = file_get_contents( $this->file );
			}
		}
		return $this;
	}
	function save() {
		if ( ! $this->file ) {
			$this->setDefaultFile();
		}
		$file = new MadView( $this->file );
		$file->saveContents( stripSlashes( $this->content ) );
	}
	function delete( $file = '' ) {
		if ( $file ) {
			$this->setFile( $file );
		}
		return unlink( $this->file );
	}
	function setDefaultFile() {
		$number = date('YmdHis');
		$this->file = $this->dir . "interview_$number.html";
		return $this;
	}
}

<?
class MadFile implements IteratorAggregate {
	protected $file = '';
	protected $data = array();

	protected $info = null;

	protected $contents = '';

	function __construct( $file = '' ) {
		$this->setFile( $file );
	}
	/******************* getter/setter *******************/
	function setFile( $file ) {
		if ( empty( $file ) ) {
			return false;
		}
		$this->file = $file;
		return $this;
	}
	function getFile() {
		return $this->file;
	}
	function getBasename( $tail = '' ) {
		$rv = explode( '/', $this->file );
		$rv = end( $rv );
		if ( $tail ) {
			$rv = rtrim( $rv, $tail );
		}
		return $rv;
	}
	function getDirname() {
		return dirName( $this->file );
	}
	function size() {
		return filesize( $this->file );
	}
	function date( $format = 'Y-m-d' ) {
		return date( $format, $this->mtime() );
	}
	function mtime() {
		return fileMtime( $this->file );
	}
	function ctime() {
		return fileCtime( $this->file );
	}
	function atime() {
		return fileAtime( $this->file );
	}
	function getData() {
		return $this->data;
	}
	function setData( $data = array() ) {
		$this->data = $data;
		return $this;
	}
	function addData( $data = array() ) {
		$this->data = array_merge( $this->data, $data );
		return $this;
	}
	function getName() {
		return baseName( $this->file );
	}
	function getExtension() {
		$temp = explode( '.', $this->getName() );
		return end( $temp );
	}
	function setInfo() {
		$this->info = new SplFileInfo( $this->file );
		return $this;
	}
	function getInfo() {
		if ( ! $this->info instanceof SplFileInfo ) {
			$this->setInfo();
		}
		return $this->info;
	}
	/******************* checks *******************/
	function isWritable() {
		return is_writable( $this->file );
	}
	function isEmpty() {
		return ( empty( $this->data ) );
	}
	function exists() {
		return file_exists( $this->file );
	}
	function isImage() {
		return exif_imagetype( $this->file );
	}
	function isText() {
		if ( preg_match( '(txt|css|js|json|php)$',$this->file ) ) {
			return true;
		}
		$info = new finfo( FILEINFO_MIME );
		return substr( $info->file( $this->file ), 0, 4 ) == 'text';
	}
	function isBinary() {
		return ! $this->isText();
	}
	function isFile() {
		if ( 0 === strpos( $this->file, 'http' ) ) {
			$headers = get_headers($this->file);
			return ! ! preg_match( '/200 OK$/', current( $headers ) );
		}
		return is_file( $this->file );
	}
	function isDir() {
		return is_dir( $this->file );
	}
	/******************* crud *******************/
	function fetch( $file ) {
		return $this->setFile( $file );
	}
	function getContents() {
		if ( ! empty( $this->contents ) ) {
			return $this->contents;
		}
		if ( ! $this->isFile() ) {
			return '';
		}
		return $this->contents = file_get_contents( $this->file );
	}
	function setContents( $contents ) {
		$this->contents = $contents;
		return $this;
	}
	function phpTemplate() {
		$phpReplaces = array( '<?' => '{{', '?>' => '}}' );
		$keys = array_keys( $phpReplaces );
		$contents = str_replace( $keys, $phpReplaces, $this->getContents() );
		$contents = htmlEntities( $contents );
		return $contents;
	}
	function phpTemplateDecode( $contents ) {
		$phpReplaces = array( '<?' => '{{', '?>' => '}}' );
		$keys = array_keys( $phpReplaces);
		$contents = html_entity_decode( $contents );
		$contents = str_replace( $phpReplaces, $keys, $contents );
		return $this->setContents( $contents );
	}
	function getSource() {
		if ( ! $this->isFile() ) {
			return '';
		}
		return show_source( $this->file, true );
	}
	function getViewer() {
		$ext = $this->getExtension();
		if ( $ext == 'html' ) {
			return $this->escapePhp();
		} elseif ( $ext == 'php' ) {
			return $this->getSource();
		}
		return nl2br( $this->getContents() );
	}
	// todo: move from here
	function escapePhp() {
		$rv = $this->getContents();
		$changes = array(
			'<?' => '&lt;?',
			'?>' => '?&gt;',
		);
		return str_replace( array_keys( $changes ), $changes, $rv );
	}
	function delete( $file = '' ) {
		if ( $file ) {
			$this->setFile( $file );
		}
		if( $this->isDir() ) {
			return rmDir( $this->file );
		} else if( $this->isFile() ) {
			return unlink( $this->file );
		}
		return false;
	}
	function save() {
		return file_put_contents( $this->file, $this->getContents() );
	}
	function saveAs( $target ) {
		$this->file = $target;
		return $this->save();
	}
	function saveContents( $contents ) {
		$this->contents = $contents;
		return $this->save();
	}
	function rename( $name ) {
		if ( ! $this->isWritable() ) {
			return false;
		}
		$target = $this->getFile();
		$dest = dirName( $target ) . '/' . $name;
		if ( ! rename( $target, $dest ) ) {
			throw new Exception( 'Rename Failure!' );
		}
		$this->file = $dest;
		return $this;
	}
	function download() {
		$basename = $this->getBasename();
		header("Content-Type: text/plain");
		header("Cache-Control: public");
		header("Content-Description: File Transfer");
		header("Content-Disposition: attachment; filename=$basename");
		header("Content-Transfer-Encoding: binary");
		print file_get_contents( $model );
		exit;
	}
	function getIndex() {
		return new MadDir( $this->file );
	}
	function getIterator() {
		if ( $this->isDir() ) {
			return new MadDir( $this->file );
		}
		if ( ! $this->isFile() ) {
			return new ArrayIterator( array() );
		}
		return new ArrayIterator( file( $this->file ) );
	}
	function __set( $key, $value ) {
		$this->data[$key] = $value;
	}
	function __get( $key ) {
		if ( ! isset( $this->data[$key] ) ) {
			return '';
		}
		return  $this->data[$key];
	}
	function __isset( $key ) {
		return isset( $this->data[$key] );
	}
	function __unset( $key ) {
		unset( $this->data[$key] );
	}
	function __toString() {
		return $this->file;
	}
	function __call( $method, $args ) {
		$info = $this->getInfo();
		if ( $info instanceof SplFileInfo ) {
			return call_user_func_array(
					array( $info, $method ),
					$args);
		}
		throw new Exception("There is no $method method in " . get_class($this) . "." );
	}
}

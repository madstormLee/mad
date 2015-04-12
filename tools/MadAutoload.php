<?
final class MadAutoload implements IteratorAggregate {
	private static $instance = null;
	private $data = array();
	private $extension = '.php';

	private function __construct() {
		spl_autoload_register( array( $this, 'autoload' ), true );
	}
	public static function getInstance() {
		return self::$instance? self::$instance : self::$instance = new self;
	}
	private function autoload( $class ) {
		// component's model load first;
		$file = lcFirst($class) . "/$class.php";
		if ( is_file( $file ) ) {
			include $file;
			return true;
		}
		foreach( $this->data as $path ) {
			if ( ! is_file( "$path/$class.php" ) ) {
				continue;
			}
			return require( "$path/$class.php" );
		}
		return false;
	}
	function getIterator() {
		return new ArrayIterator( $this->data );
	}
	public function add( $path ) {
		$this->data[] = $path;
		return $this;
	}
	public function remove( $path ) {
		foreach( $this->data as $key => $row ) {
			if ( false !== strpos( $row, $path ) ) {
				unset( $this->data[$key] );
			}
		}
		$this->data->remove( $path );
	}
}

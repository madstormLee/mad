<?
final class MadAutoload implements IteratorAggregate {
	private static $instance = null;
	private $data = array();
	private $extension = '.php';

	private function __construct() {
		spl_autoload_register( array( $this, 'autoload' ), true );
	}
	public static function getInstance() {
		if ( ! self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;
	}
	private function autoload( $class ) {
		foreach( $this->data as $path ) {
			if ( is_file( "$path/$class.php" ) ) {
				require_once( "$path/$class.php" );
				return true;
			}
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
	function test() {
		(new MadDebug)->printR( $this->data );
	}
}

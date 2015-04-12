<?
class MadModel extends MadAbstractData {
	protected $data = array();

	public static final function create( $class, $id = null ) {
		$class = ucFirst( $class );
		return class_exists( $class )? new $class($id): new self($id);
	}
	function __construct( $id = '' ) {
		$this->fetch( $id );
	}
	function getIndex() {
		$rv = new MadData;
		return $rv;
	}
	function fetch( $id = '' ) {
		if ( empty( $id ) ) {
			return false;
		}
		$this->id = $id;
	}
	function save() {
	}
	function delete( $id = '' ) {
	}
	function getComponentNavi() {
		$router = MadRouter::getInstance();
?>
<nav class='component'>
	<a class='index' href='./index'>Index</a></li>
	<? if ( $router->action != 'view' ): ?>
	<a class='write' href='./write'>Write</a></li>
	<? elseif ( $router->action == 'view' ): ?>
	<a class='edit' href='./write?id=<?=$this->id?>'>Edit</a></li>
	<a class='delete' href='./delete?id=<?=$this->id?>' data-confirm='Remove file?'>Delete</a></li>
	<? endif; ?>
</nav>
<?
	}
	function __toString() {
		return $this->id;
	}
}

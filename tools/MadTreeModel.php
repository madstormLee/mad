<?
class MadTreeModel extends MadJson {
	protected $table = '';
	protected $data = false;

	function __construct() {
		$file = 'configs/' . substr( get_class( $this ), 0, -4 ) . '/cache.json';
		parent::__construct( $file );

		if ( $this->isEmpty() ) {
			if ( empty( $this->table ) ) {
				$this->table = MadString::create( get_class( $this ) )->cut(-4)->underscore();
			}
			$this->init();
		}
	}
	public function init() {
		$query = "select * from $this->table order by parentid desc, ordernumber asc";
		$data = MadDb::create()->query( $query )->getData()->index('id');
		
		$this->setData( new MadTree( $data ) );
		$this->save();
		return $this;
	}
	function reorderFromJson( $json ) {
		$data = json_decode( $json );
		$rv = 0;
		$db = MadDb::create();
		foreach( $data as $id => $ordernumber ) {
			$query = "update $this->table set ordernumber=$ordernumber where id=$id";
			$rv += $db->exec( $query );
		}
		return $rv;
	}
}

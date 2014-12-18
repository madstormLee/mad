<?
class MadGroup {
	protected $table;
	protected $className;
	protected $tree;

	public function __construct( $tail, $database = '' ) {
		$this->className = __class__;
		$this->table = $this->className . '_' . $tail;

		$js = JsManager::getInstance();
		$js->set("/mad/js/$this->className/base");
		$style = CssManager::getInstance();
		$style->set("/mad/css/$this->className/base");

		if ( ! empty( $database ) ) {
			$this->table = $database . '.' . $this->table;
		}
		if ( ! is_table( $this->table ) ) {
			$installer = new MadInstaller();
			$installer->install($this->table);
		}
		$this->init();
	}
	public function init() {
		$query = "select * from $this->table order by relNo asc, orderNo asc";
		$q = new Q($query);

		$tuple = $q->toArray();
		$this->tree = new MadTree($tuple);
	}
	public function getName($no) {
		if ( $row = $this->tree->get($no) ) {;
			return $row['name'];
		}
		return '';
	}
	public function getTopNo($no) {
		$line = $this->tree->getLine( $no );
		return array_shift($line);
	}
	public function getTopName() {
		return $this->getName($this->getTopNo());
	}
	public function getId($no) {
		if ( $row = $this->tree->get($no) ) {
			return $row['id'];
		}
		return '';
	}
	public function getLineName($no) {
		$line = $this->tree->getLine($no);
		$rv = array();
		foreach( $line as $no ) {
			$rv[] = $this->getName($no);
		}
		return $rv;
	}
	public function rescanOrderNo() {
		foreach ( $this->tree as $no => $row ) {
			$query = "update $this->table set orderNo={$row['orderNo']} where no=$no limit 1";
			$q = new Q($query);
		}
	}
	public function rescanDepth() {
		foreach ( $this->tree as $no => $row ) {
			$depth = $row['depth'];
			$query = "update $this->table set depth=$depth where no=$no limit 1";
			new Q($query);
		}
	}
	public function __call( $func, $args ) {
		if ( method_exists( $this->tree, $func ) ) {
			if ( count( $args ) > 0 ) {
				return $this->tree->$func( $args[0] );
			} else {
				return $this->tree->$func();
			}
		}
	}
}

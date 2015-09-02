<?
class MadModel extends MadAbstractData {
	protected $name = 'MadModel';
	protected $data = array();
	protected $setting = array();

	public static final function create( $class, $id = null ) {
		$class = ucFirst( $class );
		return class_exists( $class )? new $class($id): new self($id);
	}
	function __construct() {
		$this->setName();
	}
	function getName() {
		return $this->name;
	}
	function setName( $name = '' ) {
		$this->name = empty($name) ? get_class($this) : $name;
		return $this;
	}
	function getSetting( $id='' ) {
		if ( empty( $this->setting ) ) {
			$file = lcFirst($this->getName()) . '/model.json';
			$this->setSetting( $file );
		}
		if ( ! empty( $id ) ) {
			if ( isset($this->setting->$id) ) {
				return $this->setting->$id;
			} else {
				return new MadData;
			}
		}
		return $this->setting;
	}
	function setSetting( $file='' ) {
		$this->setting = new MadJson( $file );
		return $this;
	}
	function isInstall() {
		$query = new MadQuery( $this->getName() );
		return $query->isTable();
	}
	function install() {
		return $this->getDb()->exec( new MadScheme( $this ) );
	}
	function createTable() {
		return $this->getDb()->exec( new MadScheme( $this ) );
	}
	function getHeaders() {
		return $this->getSetting()->dic('label');
	}
	function getIndex() {
		return new MadIndex( $this );
	}
	function getForms() {
		return new MadForm( $this );
	}
	// @override this
	function fetch( $id = '' ) {
		if ( empty( $id ) ) {
			return $this->fetchDefault();
		}
		MadDb::create()->read( $id, $this );
		return $this;
	}
	function fetchDefault() {
		$this->data = $this->getSetting()->dic('default')->getData();
		return $this;
	}
	function save( $data = null ) {
		if ( ! is_null( $data ) ) {
			$this->setData( $data );
		}
		return MadDb::create()->save( $this );
	}
	function delete( $id = '' ) {
		$this->id = $id;
		return MadDb::create()->delete( $this );
	}
	// @override this
	function __toString() {
		return $this->id;
	}
}

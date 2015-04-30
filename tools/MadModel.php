<?
class MadModel extends MadAbstractData {
	protected $name = 'MadModel';
	protected $data = array();
	protected $setting = array();

	public static final function create( $class, $id = null ) {
		$class = ucFirst( $class );
		return class_exists( $class )? new $class($id): new self($id);
	}
	function __construct( $id = '' ) {
		$this->setName();
		$this->fetch( $id );
	}
	function getName() {
		return $this->name;
	}
	function setName( $name = '' ) {
		$this->name = empty($name) ? get_class($this) : $name;
		return $this;
	}
	function getIndex() {
		return new MadIndex( $this );
	}
	function setSetting( $jsonFile ) {
		$this->setting = new MadJson( $jsonFile );
	}
	function getSetting( $id='' ) {
		if ( ! empty( $id ) ) {
			if ( isset($this->setting->$id) ) {
				return $this->setting->$id;
			} else {
				return new MadData;
			}
		}
		if ( empty( $this->setting ) ) {
			$this->setSetting();
		}
		return $this->setting;
	}
	function getHeaders() {
		return $this->setting->dic('label');
	}
	function getForms() {
		$rv = new MadData;
		foreach( $this->setting as $row ) {
			$row = new MadData( $row );
			if( $row->type == 'textarea' ) {
				$row->form = "<textarea name='$row->name' id='$row->id'>$row->value</textarea>";
			} else if( $row->type == 'radio' ) {
			} else if( $row->type == 'checkbox' ) {
			} else if( $row->type == 'select' ) {
			} else {
				$row->form = "<input type='$row->type' name='$row->name' id='$row->id' value='$row->value' />";
			}
			$rv->{$row->name} = $row;
		}
		return $rv;
	}
	function fetch( $id = '' ) {
		if ( empty( $id ) ) {
			return false;
		}
		$this->id = $id;
	}
	function getDb() {
		return MadConfig::getInstance()->db;
	}
	function save() {
		if ( $this->id ) {
			return $this->update();
		}
		return $this->insert();
	}
	// override this
	function insert() {
		return false;
	}
	// override this
	function update() {
		return false;
	}
	// override this
	function delete( $id = '' ) {
		return false;
	}
	// todo: remove this method.
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

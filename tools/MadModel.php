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
	function setSetting( $file ) {
		if ( ! is_file( $file ) ) {
			return $this;
		}
		$this->setting = new MadJson( $file );
		return $this;
	}
	function isInstall() {
		$query = new MadQuery( $this->getName() );
		return $query->isTable();
	}
	function getSetting( $id='' ) {
		if ( empty( $this->setting ) ) {
			$file = lcFirst($this->name) . '/model.json';
			$this->setSetting( $file );
		}
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
	function getDb() {
		return MadConfig::getInstance()->db;
	}
	function save() {
		if ( $this->id ) {
			return $this->update();
		}
		return $this->insert();
	}
	// @override this
	function fetch( $id = '' ) {
		if ( empty( $id ) ) {
			return false;
		}
		$query = new MadQuery( get_class( $this ) );
		$query->where( "id=:id");
		$statement = $this->getDb()->prepare( $query );
		$result = $statement->execute( array( 'id' => $id ) );
		$this->data = $statement->fetch(PDO::FETCH_ASSOC); 
		return $this;
	}
	// @override this
	function insert() {
		$this->wDate = date('Y-m-d H:i:s');
		$this->uDate = date('Y-m-d H:i:s');

		$query = new MadQuery( get_class($this) );
		$query->insert( array_filter($this->data) );

		$db = $this->getDb();

		$statement = $db->prepare( $query );
		$result = $statement->execute( $query->data() );
		return $db->lastInsertId();
	}
	// @override this
	function update() {
		$this->uDate = date('Y-m-d H:i:s');

		$query = new MadQuery( get_class($this) );
		$query->update( $this->data );

		$db = $this->getDb();

		$statement = $db->prepare( $query );
		$result = $statement->execute( $query->data() );

		return $statement->rowCount();
	}
	// @override this
	function delete( $id = '' ) {
		$query = "delete from Contents where id=?";

		$db = $this->getDb();

		$statement = $db->prepare( $query );
		$result = $statement->execute( array($id) );

		return $statement->rowCount();
	}
	function __toString() {
		return $this->id;
	}
	function createTable() {
		$scheme = new MadScheme( $this );
		return $this->getDb()->exec( $scheme );
	}
}

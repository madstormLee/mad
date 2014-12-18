<?
class AdminUser extends MadModel {
	private $levelNames = null;
	protected $locale = 'jp';

	public static function getRequestCount() {
		return MadDb::create()->total( 'admin_user', 'level=100' );
	}
	public function setLocale( $locale ) {
		$this->locale = $locale;
	}
	public function fetchLogin( $id, $pw ) {
		if ( empty( $id ) ) {
			throw new Exception('Id is empty!');
		}

		$id = $this->escape( $id );
		$pw = $this->escape( $pw );

		$q = MadDb::create()->query("select * from $this->table where userid = $id and pw = md5($pw)" );
		$this->setData( $q->row() );
		
		// this is root user exception.
		if ( $this->level === 0 && !($id === "'madstorm'" || $id === "'nate_kr'" )) {
			$this->clear();
		}

		$this->levelName = $this->getLevelName( $this->level );

		return $this;
	}
	public function dupliCheck( $id ) {
		if ( empty( $id ) ) {
			throw new Exception('Id is empty!');
		}

		$id = $this->escape( $id );

		$q = MadDb::create()->query("select count(userid) as cnt from $this->table where userid = $id and locale='$this->locale'" );

		if ( $q->row()->cnt > 0 ) {
			return false;
		}

		return true;
	}

	function getLevelName( $level ) {
		// this is awkward. will makes errors.
		if ( ! $this->levelNames ) {
			$this->config = new MadJson('configs/AdminUser/model.json');
			$this->levelNames = $this->config->level->get('data')->getDictionary('value', 'label' );
		}
		return $this->levelNames->$level;
	}
	public function updatePw( MadData $data ) {
		$id = $this->escape( $data->id );
		$pw = $this->escape( $data->pw );
		$query = "update \"$this->table\" set pw=md5($pw) where id=$id";
		$q = MadDb::create()->query( $query );
	}
	public function updateLevel( MadData $data ) {
		$id = $this->escape( $data->id );
		$level = $this->escape( $data->level );
		$query = "update \"$this->table\" set level=$level where id=$id";
		$q = MadDb::create()->query( $query );
	}
	function getRegistRequestTotal() {
		return $this->db->total( $this->table, '"level" = 100' );
	}
	function isUserid( $userid ) {
		return $this->db->query( "select count(*) from $this->table where userid = '$userid'")->getFirst();
	}
}

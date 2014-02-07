<?
class MadPersona extends MadUserLog {
	private static $instance;

	protected function __construct() {
		parent::__construct();
	}
	public static function getInstance(){
		if(! isset(self::$instance) ){
			self::$instance = new self;
		}
		return self::$instance;
	}
	public function isProject() {
		return !! $this->projectId;
	}
	public function setProject( $projectId ) {
		$jsonFile = "projects/$projectId/persona.json";
		if ( ! is_file( $jsonFile ) ) {
			return false;
		}
		$this->projectId = $projectId;
		return $this;
	}
	public function getProject() {
		return $this->projectId;
	}
	public function login( MadData $data ) {
		$persona = new MadJson("persona.json");
		if ( ! $info = $persona->{$data->id} ) {
			throw new Exception('No Persona Role!');
		}
		if ( $info->pw != sha1( $data->pw ) ) {
			throw new Exception('Wrong password!');
		}
		$_SESSION[__class__] = $info;
		return $this;
	}
}

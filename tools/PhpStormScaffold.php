<?
class PhpStormScaffold {
	private $data;

	function __construct( PhpStorm $phpStorm ) {
		$this->data = new MadData;
		$this->phpStorm = $phpStorm;
	}
	function __set( $key, $value ) {
		$this->data->$key = $value;
	}
	function __get( $key ) {
		return $this->data->$key;
	}
	public function create( $name ) {
		$this->name = $name;
		$this->preset = $this->phpStorm->names->preset;

		if ( ! $this->preset ) {
			$this->preset = 'MadController';
		}

		$g = MadGlobal::getInstance();
		$dirs = $g->config->dirs;
		$controllerFile = $dirs->controllers . $name . 'Controller.php';
		if ( is_file( $controllerFile ) ) {
			return false;
		}
		$template = new MadTemplate( $this->phpStorm->dirs->scaffold . "controllers/BaseController.php");
		$template->setData( $this->data );
		$template->saveAs( $controllerFile );
	}
}

<?
class MadForms extends MadData {
	private $model;
	private $ini;
	private $factory;
	private $dictionary;

	function __construct() {
		parent::__construct();
		$this->ini = new MadIni;
		$this->factory = MadFormsFactory::getInstance();
	}
	function __get( $name ) {
		$formType = 'text';
		if ( $this->ini->$name ) {
			$formType = $this->ini->$name->formType;
		}
		$form = $this->factory->create( $formType );
		$form->setData( $this->ini->$name );
		$form->name = $name;
		$form->default = $this->model->$name;
		if ( $this->dictionary->$name ) {
			$form->dictionary = $this->dictionary->$name;
		}
		return $form;
	}
	function setModel( MadModel $model ) {
		$this->model = $model;
		$modelName = get_class( $model );
		$iniFile = ROOT . "ini/$modelName.ini";
		if ( is_file( $iniFile ) ) {
			$this->ini->load( $iniFile );
		}
		return $this;
	}
	function setDictionary( MadIni $ini ) {
		$this->dictionary = $ini;
	}
	function setDefault() {
	}
}

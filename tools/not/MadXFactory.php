<?
class MadXFactory {
	protected $xTypes;
	protected $defaults;
	protected $types;
	protected $data;

	function __construct() {
		$xTypes = array(
				'text' => 'MadXText',
				'date' => 'MadXDate',
				'hidden' => 'MadXHidden',
				'select' => 'MadXSelect',
				'textarea' => 'MadXTextarea',
				'checkbox' => 'MadXCheckbox',
				'radio' => 'MadXRadio',
				);
		$this->xTypes = new MadDic($xTypes);
		$this->xTypes->setDefault( current($xTypes) );

		$this->defaults = new MadDic;
		$this->types = new MadDic;
		$this->data = new MadDic;

		$this->js = JsManager::getInstance();
		$this->style = CssManager::getInstance();
		$this->js->set('/mad/js/XForm/base');
		$this->style->set('/mad/css/XForm/base');
	}
	function setDefaults( $defaults ) {
		$this->defaults->set($defaults);
	}
	function setTypes( $types ) {
		$this->types->set($types);
	}
	function setData( $data ) {
		$this->data->set($data);
	}
	function __get( $key ) {
		$type = (string)$this->types->$key;
		$xtype = (string)$this->xTypes->$type;

		$form = new $xtype;
		$form->id = $key;
		$form->name = $key;
		$form->setData( $this->data->$key );
		$form->setDefault( $this->defaults->$key );
		return $form;
	}
}

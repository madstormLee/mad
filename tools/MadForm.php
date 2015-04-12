<?
class MadForm implements IteratorAggregate {
	private $data;

	private $model = null;
	private $types = null;

	function __construct( $data = null ) {
		MadAutoload::getInstance()->add( MADTOOLS . 'forms/' );
		$types = array(
				'hidden' => 'MadFormElement_Hidden',
				'text' => 'MadFormElement_Text',
				'email' => 'MadFormElement_Email',
				'radio' => 'MadFormElement_Radio',
				'select' => 'MadFormElement_Select',
				'checkbox' => 'MadFormElement_Checkbox',
				'file' => 'MadFormElement_File',
				'textarea' => 'MadFormElement_Textarea',
				'default' => 'MadFormElement_Text',
				);
		$this->types = new MadData( $types );
		$this->data = $data;
	}
	function isEmpty() {
		return $this->data->isEmpty();
	}
	function setModel( $model ) {
		$this->model = $model;
		return $this;
	}
	function getData() {
		return $this->data;
	}
	function setData( $data ) {
		foreach( $data as $key => $value ) {
			if ( ! is_array( $value ) ) {
				if ( $this->$key ) {
					$this->$key->value = $value;
					continue;
				}
				// 과연 setData에서 이렇게 할 필요가 있을까?
				$value = array(
					'id' => $key,
					'name' => $key,
					'type' => $this->guessType( $value ),
					'value' => $value,
				);
			}
			$this->data->$key = $value;
		}
		return $this;
	}
	private function guessType( $value ) {
		// this isn't complete
		return 'text';
	}
	function setDataFromIniFile( $filePath = '' ) {
		return $this->setDataFromIni( new MadIni( $filePath ) );
	}
	function setDataFromIni( MadIni $ini ) {
		$this->data = $ini;
		return $this;
	}
	function setDataFromConfig( MadConfig $config ) {
		foreach( $config->columns as $column ) {
			$id = $column->name;
			$data = array(
				'id' => $id,
				'name' => $column->name,
				'label' => $column->label,
				'type' => 'text',
			);
			$this->data->$id = $data;
		}
		return $this;
	}
	/********************* gettter *******************/
	function getIterator() {
		return $this->getUnits();
	}
	function getUnits() {
		$rv = new MadData;
		foreach( $this->data as $key => $data ) {
			$rv->$key = $this->getUnit( $key );
		}
		return $rv;
	}
	function getUnit( $key ) {
		if ( ! $data = $this->data->$key ) {
			$data = $this->getDefaultUnit( $key );
		}
		if ( $this->model ) {
			$data->value = $this->model->$key;
		}
		if ( ! isset( $data->value ) ) {
			$data->value = '';
		}
		$rv = new MadData;
		$rv->label = "<label for='$data->id'>$data->label</label>";
		$rv->form = "<input type='$data->type' id='$data->id' name='$data->name' value='$data->value' placeholder='$data->placeholder' />";
		return $rv;
	}
	// from MadFormFactory
	public function create( $type ) {
		if ( ! $formElement = $this->types->$type ) {
			$formElement = $this->types->default;
		}
		return new $formElement;
	}
	public function createWithData( $data ) {
		$form = $this->create( $data->type );
		if ( ! $data->label ) {
			$data->label = ( $data->kName ) ?  $data->kName : $form->name;
		}
		$form->setData( $data );
		return $form;
	}
	private function getDefaultUnit( $key ) {
		$data = new MadData( array(
					'id' => $key,
					'name' => $key,
					'label' => $key,
					)); 
		return $data;
	}
	function __get( $key ) {
		return $this->getUnit( $key );
	}
	function test() {
		$this->data->test();
	}
	/****************** special instance *****************/
	static function createFromJsonAndModel( $jsonFile, $model ) {
		$form = new self;
		$formData = new MadJson( $jsonFile );
		if ( ! $formData->isFile() ) {
			$config = $model->getConfig();
			$form->setDataFromConfig( $config );
			if ( ! $form->isEmpty() ) {
				$formData->setData( $form->getData() );
				$formData->save();
			}
		}

		$form->setData( $formData );
		$form->setModel( $model );
		return $form;
	}
}

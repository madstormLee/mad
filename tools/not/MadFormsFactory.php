<?
class MadFormsFactory {
	private static $instance;
	private $forms = null;

	private function __construct() {
		$this->forms = new MadData( array(
			'text' => 'MadForms_Text',
			'textarea' => 'MadForms_Textarea',
			'file' => 'MadForms_File',
			'radio' => 'MadForms_Radio',
			'checkbox' => 'MadForms_Checkbox',
			'select' => 'MadForms_Select',
			'hidden' => 'MadForms_Hidden',
		) );
	}
	function getInstance() {
		if ( empty( self::$instance ) ) {
			self::$instance = new self;
		}
		return self::$instance;
	}
	function create( $form = '' ) {
		if ( ! $className = $this->forms->$form ) {
			$className = 'MadForms_Text';
		}
		if ( ! class_exists( $className ) ) {
			$className = 'MadForms_Text';
		}
		return new $className;
	}
}

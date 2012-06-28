<?
class MadFormsFactory {
	private static $instance;
	private $forms = array(
		'text' => 'MadForms_Text',
		'textarea' => 'MadForms_Textarea',
		'file' => 'MadForms_File',
		'radio' => 'MadForms_Radio',
		'checkbox' => 'MadForms_Checkbox',
		'select' => 'MadForms_Select',
		'hidden' => 'MadForms_Hidden',
	);
	private function __construct() {
	}
	function getInstance() {
		if ( empty( self::$instance ) ) {
			self::$instance = new self;
		}
		return self::$instance;
	}
	function create( $form = '' ) {
		if ( ! $form = ckKey( $form, $this->forms ) ) {
			$form = 'MadForms_Text';
		}
		if ( ! class_exists( $form ) ) {
			$form = 'MadForms_Text';
		}
		return new $form;
	}
}

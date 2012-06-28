<?
class PhpinfoController extends Preset {
	function indexAction() {
		$options = new MadData( array(
				'INFO_GENERAL' => array(
					'value' => INFO_GENERAL,
					'brief' => 'The configuration line, php.ini location, build date, Web Server, System and more.',
					),
				'INFO_CREDITS' => array(
					'value' => INFO_CREDITS,
					'brief' => 'PHP Credits. See also phpcredits().',
					),
				'INFO_CONFIGURATION' => array(
					'value' => INFO_CONFIGURATION,
					'brief' => 'Current Local and Master values for PHP directives. See also ini_get().',
					),
				'INFO_MODULES' => array(
					'value' => INFO_MODULES,
					'brief' => 'Loaded modules and their respective settings. See also get_loaded_extensions().',
					),
				'INFO_ENVIRONMENT' => array(
					'value' => INFO_ENVIRONMENT,
					'brief' => 'Environment Variable information that\'s also available in $_ENV.',
					),
				'INFO_VARIABLES' => array(
						'value' => INFO_VARIABLES,
						'brief' => 'Shows all predefined variables from EGPCS (Environment, GET, POST, Cookie, Server).',
						),
				'INFO_LICENSE' => array(
						'value' => INFO_LICENSE,
						'brief' => 'PHP License information. See also the » license FAQ.',
						),
				'INFO_ALL' => array(
						'value' => INFO_ALL,
						'brief' => 'Shows all of the above. ',
						),
				) );
		// 이 부분은 나중에.
		// $this->left->actions = $options->getDictionary('value','reverse');
		ob_start();
		phpinfo();
		return ob_get_clean();
	}
}


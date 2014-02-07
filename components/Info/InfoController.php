<?
class InfoController extends MadController {
	function indexAction() {
	}
	function phpAction() {
		$get = $this->get;

		$options = array(
				'general' => INFO_GENERAL,
				'credits' => INFO_CREDITS,
				'configs' => INFO_CONFIGURATION,
				'modules' => INFO_MODULES,
				'env' => INFO_ENVIRONMENT,
				'var' => INFO_VARIABLES,
				'license' => INFO_LICENSE,
				'all' => INFO_ALL,
				);

		
		if ( ! $get->option ) {
			$get->option = $options['general'];
		}
		// this is for pointing current status

		ob_start();
		phpinfo( $get->option );
		$this->main->info = ob_get_clean();

		$this->main->options = $options;
	}
}

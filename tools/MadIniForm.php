<?
class MadIniForm extends Mad {
	private $ini;
	function __construct( MadIni $ini ) {
		parent::__construct();
		$this->ini = $ini;
	}
	function __toString() {
		$view = new MadView(MAD . '/views/iniForm');
		$view->ini = $this->ini;
		return $view->get();
	}
}

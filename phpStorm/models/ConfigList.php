<?
class ConfigList extends MadJsonList {
	function __construct( $dir = '' ) {
		parent::__construct( $dir );
		$this->setModelName('MadConfig');
	}
}

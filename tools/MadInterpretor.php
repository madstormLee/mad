<?
class MadInterpretor extends MadJson {
	private $action;
	private $actionData;
	private $result;
	function __construct( $controllerName, $actionName ) {
		$file = "configs/$controllerName/controller.json";
		if ( ! is_file( $file ) ) {
			$file = "configs/interpret.json";
			if ( ! is_file( "configs/interpret.json" ) ) {
				$file = PX_ROOT . "configs/interpret.json";
			}
		}
		parent::__construct( $file );
		$this->action = $actionName;
		$this->actionData = $this->{$this->action};
	}
	function setResult( &$result ) {
		$this->result = $result;
		return $this;
	}
	function getAfterUrl() {
		if( $target = $this->actionData->{$this->result} ) {
			return $target->url;
		}
		return '';
	}
	function interpret() {
		if( $target = $this->actionData->{$this->result} ) {
			return $target->message;
		}
		return '';
	}
	function interpretUrl() {
		$g = MadGlobals::getInstance();
		$rv = preg_replace('!(action|background|src|href)=(["\'])~/!i', "$1=$2{$g->projectRoot}/", $this->result );
		$rv = preg_replace('!(action|background|src|href)=(["\'])\./!i', "$1=$2{$g->projectRoot}/{$g->controllerName}/", $rv );
		return $rv;
	}
}

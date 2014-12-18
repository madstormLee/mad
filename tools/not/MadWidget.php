<?
class MadWidget extends MadData {
	protected $view = '';
	protected $style;
	protected $js;

	function __construct() {
		$this->style = CssManager::getInstance();
		$this->js = JsManager::getInstance();
	}
	function setView( $view ) {
		$this->view = $view;
		return $this;
	}
	function getView() {
		return $this->view;
	}
	function get() {
		if (! is_file($this->view)) {
			return get_class( $this ) . " : $this->view 파일이 존재하지 않습니다.";
		}
		extract( $this->data );
		ob_start();
		include $this->view;
		return ob_get_clean();
	}
	function __toString() {
		return $this->get();
	}
}

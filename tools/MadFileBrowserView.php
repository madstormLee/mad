<?
class MadFileBrowserView extends MadView {
	function __construct() {
		parent::__construct(MAD . 'views/FileBrowser/index');
		MadJs::getInstance()->add('/mad/js/FileBrowser/index');
		MadCss::getInstance()->add('/mad/css/FileBrowser/index');
	}
	function setFilter( $filter ) {
		$this->filter = $filter;
		return $this;
	}
	function setStyle( $style ) {
		$this->style = $style;
		return $this;
	}
	function setDir( $dir ) {
		$this->dir = $dir;
		return $this;
	}
	function get() {
		if ( ! $this->dir || ! is_dir( $this->dir ) ) {
			$this->dir = ROOT;
		}
		$this->dirs = new MadDir( $this->dir );
		$this->dirs->setFilter('dirs');
		$this->files = new MadDir( $this->dir );
		$this->files->setType( $this->filter );

		return parent::get();
	}
}

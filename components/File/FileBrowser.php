<?
class FileBrowser extends MadView {
	function __construct( $dir='images', $type='image' ) {

		MadCss::getInstance()->add( '~/css/admin/File/browser.css' );
		MadJs::getInstance()->addNext("/venders/swfUploader/swfupload.js", 'jquery')
			->addNext( '~/js/admin/File/swfuploader.js', 'swfupload' );
		$get = MadParam::create('get');

		$this->data['dir'] = $dir;
		$this->data['type'] = $type;
		$_SESSION['upload_dir'] = $dir;
		parent::__construct('views/admin/File/browser.html');
	}
	function getContents() {
		$content = parent::getContents();
		$periodPath = 'admin/file';
		$g = MadGlobals::getInstance();
		$rv = preg_replace('!(action|background|src|href)=(["\'])~/!i', "$1=$2{$g->projectRoot}/", $content );

		$rv = preg_replace('!(action|background|src|href)=(["\'])\.!i', "$1=$2{$g->projectRoot}/{$periodPath}", $rv );
		return $rv;
	}
}
